<?php

namespace App\Livewire\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Traits\WithLoading;
use App\Traits\WithNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RoleManager extends Component
{
    use WithLoading;
    use WithNotification;
    use WithPagination;

    /**
     * Properties untuk form
     */
    #[Locked]
    public ?int $role_id = null;

    public string $name = '';
    public array $permissions = [];
    public array $selected_permissions = [];
    public array $grouped_permissions = [];

    /**
     * Properties untuk modal
     */
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public string $modalTitle = '';

    /**
     * Properties untuk filter dan search
     */
    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public int $per_page = 10;

    /**
     * Cache keys
     */
    private const PERMISSIONS_CACHE_KEY = 'all_permissions';
    private const GROUPED_PERMISSIONS_CACHE_KEY = 'grouped_permissions';
    private const CACHE_TTL = 3600; // 1 jam

    /**
     * Rules untuk validasi
     */
    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('roles', 'name')->ignore($this->role_id),
            ],
            'selected_permissions' => 'required|array|min:1',
        ];
    }

    /**
     * Custom error messages
     */
    protected function messages(): array
    {
        return [
            'name.regex' => 'Nama role hanya boleh mengandung huruf kecil, angka, dan underscore.',
            'selected_permissions.min' => 'Pilih minimal 1 permission.',
        ];
    }

    /**
     * Lifecycle hooks
     */
    public function mount(): void
    {
        $this->loadPermissions();
    }

    /**
     * Load permissions with caching
     */
    private function loadPermissions(): void
    {
        // Load all permissions for select input
        $this->permissions = Cache::remember(self::PERMISSIONS_CACHE_KEY, self::CACHE_TTL, function () {
            return Permission::ordered()
                ->get()
                ->map(fn ($permission) => [
                    'value' => $permission->name,
                    'label' => $permission->formatted_name,
                ])
                ->toArray();
        });

        // Load grouped permissions for display
        $this->grouped_permissions = Cache::remember(self::GROUPED_PERMISSIONS_CACHE_KEY, self::CACHE_TTL, function () {
            return Permission::ordered()
                ->get()
                ->groupBy('group')
                ->map(fn ($permissions) => $permissions->map(fn ($permission) => [
                    'name' => $permission->name,
                    'label' => $permission->clean_name,
                ]))
                ->toArray();
        });
    }

    /**
     * Reset form
     */
    private function resetForm(): void
    {
        $this->reset([
            'role_id',
            'name',
            'selected_permissions',
            'showModal',
            'showDeleteModal',
            'modalTitle',
        ]);
        $this->resetErrorBag();
    }

    /**
     * Create new role
     */
    public function create(): void
    {
        $this->resetForm();
        $this->modalTitle = 'Tambah Role';
        $this->showModal = true;
    }

    /**
     * Edit role
     */
    public function edit(int $id): void
    {
        $this->resetForm();
        $this->role_id = $id;
        $this->modalTitle = 'Edit Role';

        $role = Role::with('permissions')->findOrFail($id);
        $this->name = $role->name;
        $this->selected_permissions = $role->permissions->pluck('name')->toArray();

        $this->showModal = true;
    }

    /**
     * Save role
     */
    public function save(): void
    {
        $this->loading(function () {
            $validated = $this->validate();

            try {
                DB::beginTransaction();

                if ($this->role_id) {
                    $role = Role::findOrFail($this->role_id);

                    // Prevent editing admin role name
                    if (!$role->is_name_editable && $validated['name'] !== 'admin') {
                        throw new \Exception('Role admin tidak dapat diubah namanya!');
                    }

                    $role->update(['name' => $validated['name']]);
                } else {
                    $role = Role::create(['name' => $validated['name']]);
                }

                // Sync permissions
                $role->syncPermissions($validated['selected_permissions']);

                DB::commit();

                // Clear cache
                Cache::tags(['roles', 'permissions'])->flush();

                $this->resetForm();
                $this->success($this->role_id ? 'Role berhasil diperbarui!' : 'Role berhasil ditambahkan!');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    /**
     * Confirm delete
     */
    public function confirmDelete(int $id): void
    {
        $role = Role::findOrFail($id);

        // Prevent deletion of admin role
        if (!$role->is_deletable) {
            $this->error('Role admin tidak dapat dihapus!');
            return;
        }

        $this->role_id = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Delete role
     */
    public function delete(): void
    {
        $this->loading(function () {
            try {
                DB::beginTransaction();

                $role = Role::findOrFail($this->role_id);

                // Check if role is deletable
                if (!$role->is_deletable) {
                    throw new \Exception('Role tidak dapat dihapus!');
                }

                $role->delete();

                DB::commit();

                // Clear cache
                Cache::tags(['roles', 'permissions'])->flush();

                $this->resetForm();
                $this->success('Role berhasil dihapus!');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    /**
     * Get roles query
     */
    #[Computed]
    public function roles()
    {
        return Role::query()
            ->with(['permissions' => fn ($query) => $query->ordered()])
            ->withCount('users')
            ->when($this->search, fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->ordered()
            ->paginate($this->per_page);
    }

    /**
     * Render view
     */
    public function render()
    {
        return view('livewire.admin.role-manager', [
            'roles' => $this->roles,
        ]);
    }
}
