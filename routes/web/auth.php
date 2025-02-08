<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\{
    Login,
    LoginKacap,
    LoginSiswa,
    LoginTentor
};

Route::name('login.')->group(function () {
    Route::get('/admin/login', Login::class)->name('admin');
    Route::get('/siswa/login', LoginSiswa::class)->name('siswa');
    Route::get('/kacap/login', LoginKacap::class)->name('kacap');
    Route::get('/tentor/login', LoginTentor::class)->name('tentor');
});
