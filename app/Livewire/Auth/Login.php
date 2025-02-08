<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\{Layout, Rule, Locked};
use Livewire\Component;
use Mary\Traits\Toast;

#[Layout('components.layouts.auth', ['title' => 'Login Admin'])]
final class Login extends Component
{
    use Toast;

    /**
     * Maximum login attempts before throttling
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Decay minutes for throttling
     */
    private const DECAY_MINUTES = 1;

    #[Rule(['required', 'email', 'exists:users,email'])]
    public string $email = '';

    #[Rule(['required', 'string', 'min:6'])]
    public string $password = '';

    #[Locked]
    public bool $remember = false;

    /**
     * Validation error messages
     */
    protected array $messages = [
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.exists' => 'Email tidak terdaftar',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 6 karakter',
        'password.string' => 'Password harus berupa string'
    ];

    /**
     * Get throttle key for rate limiting
     */
    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    /**
     * Check if too many login attempts
     *
     * @throws ValidationException
     */
    private function checkTooManyAttempts(): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Increment the login attempts
     */
    private function incrementLoginAttempts(): void
    {
        RateLimiter::hit($this->throttleKey(), self::DECAY_MINUTES * 60);
    }

    /**
     * Clear the login attempts
     */
    private function clearLoginAttempts(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Attempt to authenticate the user
     *
     * @param array<string, mixed> $credentials
     * @throws ValidationException
     */
    private function attemptLogin(array $credentials): void
    {
        if (!Auth::attempt($credentials, $this->remember)) {
            $this->incrementLoginAttempts();

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $this->clearLoginAttempts();
    }

    /**
     * Handle successful login
     */
    private function handleSuccessfulLogin(): void
    {
        session()->regenerate();

        $user = Auth::user();

        if (!$user?->hasRole('admin')) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Akun ini tidak memiliki akses admin.',
            ]);
        }

        $this->success(
            title: 'Berhasil!',
            description: 'Selamat datang di dashboard admin'
        );

        $this->redirectRoute('admin.dashboard');
    }

    /**
     * Handle login attempt
     *
     * @throws ValidationException
     */
    public function login(): void
    {
        try {
            $this->checkTooManyAttempts();

            $credentials = $this->validate();

            $this->attemptLogin($credentials);

            $this->handleSuccessfulLogin();

        } catch (ValidationException $e) {
            $this->error(
                title: 'Gagal!',
                description: $e->getMessage()
            );
            throw $e;
        } catch (\Throwable $e) {
            logger()->error('Admin Login Error', [
                'message' => $e->getMessage(),
                'email' => $this->email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            $this->error(
                title: 'Error!',
                description: 'Terjadi kesalahan saat login'
            );

            throw $e;
        }
    }

    /**
     * Render the login view
     */
    public function render(): View
    {
        return view('livewire.auth.login');
    }
}
