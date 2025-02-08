<?php

namespace App\Livewire\Auth;

use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TentorServiceInterface;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

#[Layout('components.layouts.auth', ['title' => 'Login Tentor'])]
class LoginTentor extends Component
{
    use Toast;

    /** @var AuthServiceInterface */
    protected AuthServiceInterface $authService;

    /** @var TentorServiceInterface */
    protected TentorServiceInterface $tentorService;

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:6')]
    public string $password = '';

    public bool $remember = false;

    protected array $messages = [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter'
    ];

    public function boot(
        AuthServiceInterface $authService,
        TentorServiceInterface $tentorService
    ): void {
        $this->authService = $authService;
        $this->tentorService = $tentorService;
    }

    public function login(): void
    {
        try {
            $credentials = $this->validate();

            if ($this->authService->login($credentials)) {
                $user = $this->authService->getCurrentUser();

                if (!$user->hasRole('tentor')) {
                    $this->authService->logout();
                    $this->error('Akun ini tidak memiliki akses sebagai Tentor');
                    return;
                }

                $this->success('Login berhasil');
                $this->redirect(route('tentor.dashboard'));
            } else {
                $this->error('Email atau password salah');
            }
        } catch (\Exception $e) {
            $this->error('Gagal melakukan login: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login-tentor');
    }
}
