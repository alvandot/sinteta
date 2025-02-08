<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Cabang;
use App\Models\User;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

#[Layout('components.layouts.app')]
final class Index extends Component
{
    use Interactions;

    #[Locked]
    public User $userCurrent;

    #[Locked]
    public array $roles = [];

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    public bool $drawer = false;

    private bool $toastShown = false;

    public $roleFilter = '';
    public $cabangFilter = '';
    public $cabangs;

    public function mount(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->userCurrent = $user;
        $this->roles = $this->userCurrent->getRoleNames()->toArray();

        if (!$this->toastShown) {
            $this->showWelcomeToast();
            $this->toastShown = true;
        }

        $this->drawer = false;

        $this->cabangs = Cabang::all();
    }

    #[Computed]
    public function tentor(): int
    {
        return cache()->remember('tentor_count', now()->addMinutes(5), function (): int {
            return Tentor::count();
        });
    }

    #[Computed]
    public function siswa(): int
    {
        return cache()->remember('siswa_count', now()->addMinutes(5), function (): int {
            return Siswa::count();
        });
    }

    #[Computed]
    public function cabang(): int
    {
        return cache()->remember('cabang_count', now()->addMinutes(5), function (): int {
            return Cabang::count();
        });
    }

    #[Computed]
    public function users(): Collection
    {
        return User::query()
            ->when($this->search, function (Builder $query): Builder {
                return $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->with('roles')
            ->get();
    }

    #[Computed]
    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => 'Nama', 'class' => 'w-64', 'sortable' => true],
            ['key' => 'email', 'label' => 'Email', 'class' => 'w-20', 'sortable' => true],
            ['key' => 'roles', 'label' => 'Role', 'class' => 'w-20'],
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search']);
        $this->resetValidation();
        $this->toast()
            ->success(
                title: 'Berhasil!',
                description: 'Filter berhasil direset.',
            )
            ->send();
    }

    public function delete(int $id): void
    {
        // Implementasi delete sebenarnya akan ditambahkan nanti
        $this->warning(
            title: 'Peringatan',
            description: "Akan menghapus user #$id",
            position: 'toast-bottom'
        );
    }

    private function showWelcomeToast(): void
    {
        $this->toast()
            ->success(
                title: 'Berhasil!',
                description: 'Selamat datang di dashboard admin!'
            )
            ->send();
    }

    public function render(): View
    {
        return view('livewire.admin.index', [
            'users' => $this->users,
            'headers' => $this->headers,
            'tentor_count' => $this->tentor,
            'siswa_count' => $this->siswa,
            'cabang_count' => $this->cabang,
        ]);
    }

    #[Computed]
    public function currentTime(): string
    {
        return now()->format('H:i:s');
    }
}
