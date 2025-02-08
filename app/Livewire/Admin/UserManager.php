<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Traits\WithLoading;
use App\Traits\WithNotification;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManager extends Component
{
    use WithLoading;
    use WithNotification;
    use WithFileUploads;
    use WithPagination;

    // Properties untuk form
    public $user_id;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = '';
    public $avatar;
    public $is_active = true;

    // Properties untuk modal
    public $showModal = false;
    public $showDeleteModal = false;
    public $modalTitle = '';

    // Properties untuk filter dan search
    public $search = '';
    public $role_filter = '';
    public $status_filter = '';
    public $per_page = 10;

    // Rules untuk validasi
    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => $this->user_id ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'password_confirmation' => $this->user_id ? 'nullable|min:8' : 'required|min:8',
            'role' => 'required',
            'avatar' => 'nullable|image|max:1024', // 1MB Max
            'is_active' => 'boolean',
        ];
    }

    // Reset form
    public function resetForm()
    {
        $this->reset([
            'user_id',
            'name',
            'email',
            'password',
            'password_confirmation',
            'role',
            'avatar',
            'is_active',
            'showModal',
            'showDeleteModal',
            'modalTitle',
        ]);
        $this->resetErrorBag();
    }

    // Create new user
    public function create()
    {
        $this->resetForm();
        $this->modalTitle = 'Tambah Pengguna';
        $this->showModal = true;
    }

    // Edit user
    public function edit($id)
    {
        $this->resetForm();
        $this->user_id = $id;
        $this->modalTitle = 'Edit Pengguna';

        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name;
        $this->is_active = $user->is_active;

        $this->showModal = true;
    }

    // Save user
    public function save()
    {
        $this->loading(function () {
            $validated = $this->validate();

            try {
                if ($this->user_id) {
                    $user = User::findOrFail($this->user_id);
                    $user->update([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'is_active' => $validated['is_active'],
                    ]);

                    if ($validated['password']) {
                        $user->update(['password' => Hash::make($validated['password'])]);
                    }
                } else {
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'password' => Hash::make($validated['password']),
                        'is_active' => $validated['is_active'],
                    ]);
                }

                // Sync roles
                $user->syncRoles([$validated['role']]);

                // Handle avatar upload
                if ($this->avatar) {
                    $user->clearMediaCollection('avatar');
                    $user->addMedia($this->avatar)->toMediaCollection('avatar');
                }

                $this->resetForm();
                $this->success($this->user_id ? 'Pengguna berhasil diperbarui!' : 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
                $this->error('Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    // Confirm delete
    public function confirmDelete($id)
    {
        $this->user_id = $id;
        $this->showDeleteModal = true;
    }

    // Delete user
    public function delete()
    {
        $this->loading(function () {
            try {
                $user = User::findOrFail($this->user_id);
                $user->delete();

                $this->resetForm();
                $this->success('Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
                $this->error('Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    // Get users query
    public function getUsersQuery()
    {
        $query = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->role_filter, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->role_filter);
                });
            })
            ->when($this->status_filter !== '', function ($query) {
                $query->where('is_active', $this->status_filter);
            });

        return $query;
    }

    public function render()
    {
        return view('livewire.admin.user-manager', [
            'users' => $this->getUsersQuery()->paginate($this->per_page),
            'roles' => Role::pluck('name', 'name')->map(function ($name) {
                return [
                    'value' => $name,
                    'label' => ucwords(str_replace('_', ' ', $name)),
                ];
            })->values()->all(),
        ]);
    }
}
