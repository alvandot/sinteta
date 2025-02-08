<?php

namespace App\Livewire\Auth;

use App\Services\Contracts\AuthServiceInterface;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

#[Layout('components.layouts.auth', ['title' => 'Login Kepala Cabang'])]
class LoginKacap extends Component
{
    use Toast;

    /** @var AuthServiceInterface */
    protected AuthServiceInterface $authService;

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

    public function boot(AuthServiceInterface $authService): void
    {
        $this->authService = $authService;
    }

    public function login(): void
    {
        try {
            $credentials = $this->validate();

            if ($this->authService->login($credentials)) {
                $user = $this->authService->getCurrentUser();

                if (!$user->hasRole('kacap')) {
                    $this->authService->logout();
                    $this->error('Akun ini tidak memiliki akses sebagai Kepala Cabang');
                    return;
                }

                $this->success('Login berhasil');
                $this->redirect(route('kacap.dashboard'));
            } else {
                $this->error('Email atau password salah');
            }
        } catch (\Exception $e) {
            $this->error('Gagal melakukan login: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login-kacap');
    }
}
