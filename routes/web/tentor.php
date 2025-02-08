<?php

declare(strict_types=1);

use App\Livewire\Tentor\Index as TentorIndex;
use App\Livewire\Tentor\Jadwal\DaftarJadwal;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
Route::middleware(['TentorAuth'])
    ->prefix('tentor')
    ->name('tentor.')
    ->group(function () {
        Route::get('/', TentorIndex::class)->name('index');
        Route::get('/dashboard', TentorIndex::class)->name('dashboard');
        Route::get('/logout', [AuthController::class, 'logoutTentor'])->name('logout');
        Route::get('/jadwal', DaftarJadwal::class)->name('jadwal');
        Route::get('/jadwal/{jadwalBelajarId}/absensi', \App\Livewire\Tentor\Absensi\DaftarAbsensi::class)->name('absensi');

        Route::fallback(function () {
            return redirect()
                ->route('tentor.dashboard')
                ->with('error', 'Halaman tentor tidak ditemukan');
        });
    });

