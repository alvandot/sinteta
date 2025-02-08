<?php

declare(strict_types=1);
use App\Livewire\Kacap\Absensi\DaftarAbsensi;
use Illuminate\Support\Facades\Route;
use App\Livewire\Kacap\{
    Dashboard,
    Kelas\Index as KelasIndex,
    Kurikulum\DaftarMataPelajaran,
    Kurikulum\DaftarTentor,
    Siswa\ListSiswa,
    Siswa\Pendaftaran
};
use App\Http\Controllers\AuthController;

Route::middleware(['KacapAuth'])
    ->prefix('kacap')
    ->name('kacap.')
    ->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');

        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/daftar', ListSiswa::class)->name('index');
            Route::get('/pendaftaran', Pendaftaran::class)->name('create');
        });

        Route::prefix('kelas')->name('kelas.')->group(function () {
            Route::get('/', KelasIndex::class)->name('index');
        });

        Route::prefix('kurikulum')->name('kurikulum.')->group(function () {
            Route::get('/pengajar', DaftarTentor::class)->name('pengajar');
            Route::get('/mata-pelajaran', DaftarMataPelajaran::class)->name('mata_pelajaran');
        });

        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/', DaftarAbsensi::class)->name('index');
        });

        Route::get('/logout', [AuthController::class, 'logoutKacap'])->name('logout');

        Route::fallback(function () {
            return redirect()
                ->route('kacap.dashboard')
                ->with('error', 'Halaman kepala cabang tidak ditemukan');
        });
    });
