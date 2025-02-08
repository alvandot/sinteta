<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.auth', ['title' => 'Login Siswa'])]
class LoginSiswa extends Component
{
    use Toast;

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required|min:6')]
    public string $password = '';


    public function login(): void
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (!Auth::guard('siswa')->attempt($credentials)) {
            $this->error('Email atau password salah');
            return;
        }

        session()->regenerate();
        $this->success('Login berhasil');
        $this->redirect(route('siswa.dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login-siswa');
    }
}
