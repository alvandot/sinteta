<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TentorAuth
{
    /**
     * Pesan error ketika belum login
     *
     * @var string
     */
    protected $message = 'Silakan login terlebih dahulu';

    /**
     * Route untuk redirect ketika belum login
     *
     * @var string
     */
    protected $redirectTo = 'login.tentor';

    /**
     * Handle permintaan yang masuk.
     * Cek apakah user sudah terautentikasi sebagai tentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isAuthenticated()) {
            return $this->redirectToLogin();
        }

        return $next($request);
    }

    /**
     * Cek apakah user sudah terautentikasi
     *
     * @return bool
     */
    protected function isAuthenticated(): bool
    {
        return auth()->check() && auth()->user()->hasRole('tentor');
    }

    /**
     * Redirect ke halaman login dengan pesan error
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToLogin()
    {
        return redirect()
            ->route($this->redirectTo)
            ->with('error', $this->message);
    }
}
