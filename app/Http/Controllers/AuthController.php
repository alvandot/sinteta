<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

class AuthController extends Controller
{
    use Interactions;

    /**
     * Logout siswa dan redirect ke halaman login siswa
     */
    public function logoutSiswa(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->toast()
            ->success('Berhasil!', 'Anda telah berhasil logout.')
            ->send();

        return redirect()->route('login.siswa');
    }

    /**
     * Logout admin dan redirect ke halaman login admin
     */
    public function logoutAdmin(): RedirectResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->route('login.admin');
        }

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->toast()
            ->success('Berhasil!', 'Anda telah berhasil logout.')
            ->send();

        return redirect()->route('login.admin');
    }

    /**
     * Logout kacap dan redirect ke halaman login kacap
     */
    public function logoutKacap(): RedirectResponse
    {
        if (!auth()->user()->hasRole('kacap')) {
            return redirect()->route('login.kacap');
        }

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->toast()
            ->success('Berhasil!', 'Anda telah berhasil logout.')
            ->send();

        return redirect()->route('login.kacap');
    }

    /**
     * Logout tentor dan redirect ke halaman login tentor
     */
    public function logoutTentor(): RedirectResponse
    {
        if (!auth()->user()->hasRole('tentor')) {
            return redirect()->route('login_tentor');
        }

        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->toast()
            ->success('Berhasil!', 'Anda telah berhasil logout.')
            ->send();

        return redirect()->route('login.tentor');
    }
}
