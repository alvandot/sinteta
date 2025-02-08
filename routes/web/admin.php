<?php

declare(strict_types=1);

use App\Livewire\Admin\Cabang\DetailCabang;
use App\Livewire\Admin\Jadwal\BuatJadwal;
use App\Livewire\Admin\Jadwal\DaftarJadwal;
use App\Livewire\Admin\RoleManager;
use App\Livewire\Admin\Siswa\BuatSiswa;
use App\Livewire\Admin\Siswa\DetailSiswa;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\{
    Index as AdminIndex,
    UserManager,
    Soal\BuatSoal,
    Soal\DaftarSoal,
    Soal\DetailSoal,
    Soal\EditSoal,
    Siswa\DaftarSiswa,
    KelasBimbel\DaftarKelasBimbel,
    Ujian\BuatUjian,
    Ujian\DaftarUjian,
    Ujian\DetailUjian,
    Cabang\DaftarCabang,
    MataPelajaran\DaftarMataPelajaran,
};
use App\Http\Controllers\AuthController;

Route::middleware(['AdminAuth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', AdminIndex::class)->name('dashboard');
        Route::get('/user-manager', UserManager::class)->name('user_manager');

        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', DaftarJadwal::class)->name('index');
            Route::get('/buat', BuatJadwal::class)->name('create');
        });

        Route::prefix('soal')->name('soal.')->group(function () {
            Route::get('/daftar', DaftarSoal::class)->name('index');
            Route::get('/buat', BuatSoal::class)->name('create');
            Route::get('/detail/{id}', DetailSoal::class)->name('show');
            Route::get('/edit/{id}', EditSoal::class)->name('edit');
        });

        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/buat', BuatUjian::class)->name('create');
            Route::get('/daftar', DaftarUjian::class)->name('index');
            Route::get('/detail/{id}', DetailUjian::class)->name('show');
        });

        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/daftar', DaftarSiswa::class)->name('index');
            Route::get('/detail/{id}', DetailSiswa::class)->name('show');
            Route::get('/buat', BuatSiswa::class)->name('create');
        });

        Route::prefix('cabang')->name('cabang.')->group(function () {
            Route::get('/daftar', DaftarCabang::class)->name('index');
            Route::get('/detail/{id}', DetailCabang::class)->name('show');
        });

        Route::prefix('kelas-bimbel')->name('kelas_bimbel.')->group(function () {
            Route::get('/daftar', DaftarKelasBimbel::class)->name('index');
        });

        Route::prefix('absensi')->name('absensi.')->group(function () {
            Route::get('/daftar', \App\Livewire\Admin\Absensi\Daftar::class)->name('index');
        });

        Route::prefix('mata-pelajaran')->name('mata_pelajaran.')->group(function () {
            Route::get('/daftar', DaftarMataPelajaran::class)->name('index');
        });

        Route::get('/users', UserManager::class)->name('admin.users');
        Route::get('/roles', RoleManager::class)->name('admin.roles');

        Route::get('/logout', [AuthController::class, 'logoutAdmin'])->name('logout');

        Route::get('/cabang/{cabang}', \App\Livewire\Admin\Cabang\DetailCabang::class)->name('admin.cabang.detail');

        Route::fallback(function () {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Halaman admin tidak ditemukan');
        });
    });
