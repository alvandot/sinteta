<?php

declare(strict_types=1);

use App\Livewire\Admin\Ujian\DetailUjian;
use App\Livewire\Siswa\{
    Index,
    Jadwal\DaftarJadwal,
    Jadwal\RiwayatJadwal,
    Ujian\DaftarUjian as SiswaDaftarUjian,
    Ujian\OnUjian
};
use App\Http\Controllers\AuthController;

use App\Livewire\Siswa\Ujian\RiwayatHasilUjian;
use App\Models\DaftarUjianSiswa;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::middleware(['SiswaAuth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', Index::class)->name('dashboard');

        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', DaftarJadwal::class)->name('index');
            Route::get('/riwayat', RiwayatJadwal::class)->name('riwayat');
        });

        Route::prefix('ujian')->name('ujian.')->group(function () {
            Route::get('/', SiswaDaftarUjian::class)->name('index');
            Route::get('/detail/{id}', DetailUjian::class)->name('detail');
            Route::get('/on-ujian/{id_ujian}', OnUjian::class)->name('on-ujian');
            Route::get('/riwayat', RiwayatHasilUjian::class)->name('riwayat');
        });

        Route::get('/logout', [AuthController::class, 'logoutSiswa'])->name('logout');

        Route::get('/download-hasil-ujian/{filename}', function ($filename) {
            // Validasi extension
            if (!Str::endsWith($filename, '.pdf')) {
                abort(404);
            }

            $path = storage_path('app/public/hasil-ujian/' . $filename);

            if (!file_exists($path)) {
                abort(404);
            }

            // Tambahkan header untuk force browser menampilkan PDF
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'X-Content-Type-Options' => 'nosniff'
            ]);
        })->middleware(['auth:siswa'])->name('download.hasil-ujian');



    // Route untuk export hasil ujian ke PDF
    Route::post('/hasil-ujian/{id}/export', function ($id) {
        $daftarUjian = DaftarUjianSiswa::with(['ujian.paketSoal.soals', 'siswa.kelasBimbel'])->findOrFail($id);

        if ($daftarUjian->status !== 'selesai' || $daftarUjian->siswa_id !== auth()->guard('siswa')->id()) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $data = [
            'id_ujian' => $id,
            'nama_siswa' => $daftarUjian->siswa->nama_lengkap,
            'kelas_siswa' => $daftarUjian->siswa->kelasBimbel->nama_kelas ?? '-',
            'nama_ujian' => $daftarUjian->ujian->nama,
            'tanggal' => $daftarUjian->created_at->format('d F Y'),
            'waktu_mulai' => $daftarUjian->created_at->format('H:i'),
            'waktu_selesai' => $daftarUjian->waktu_selesai->format('H:i'),
            'nilai' => $daftarUjian->nilai,
            'jawaban' => $daftarUjian->jawaban,
            'soal' => $daftarUjian->ujian->paketSoal->soals
        ];

        $pdf = Pdf::loadView('pdf.hasil-ujian', $data);

        $filename = 'hasil_ujian_' . Str::slug($daftarUjian->siswa->nama_lengkap) . '_' . now()->format('Y-m-d_H-i') . '.pdf';

        return $pdf->download($filename);
    })->name('siswa.export-hasil-ujian');

    // Route untuk verifikasi hasil ujian
    Route::get('/verify-hasil-ujian/{id}', function ($id) {
        $daftarUjian = DaftarUjianSiswa::with(['ujian', 'siswa.kelasBimbel'])->findOrFail($id);

        if ($daftarUjian->status !== 'selesai') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hasil ujian tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'nama_siswa' => $daftarUjian->siswa->nama_lengkap,
                'kelas' => $daftarUjian->siswa->kelasBimbel->nama_kelas ?? '-',
                'nama_ujian' => $daftarUjian->ujian->nama,
                'tanggal' => $daftarUjian->created_at->format('d F Y'),
                'nilai' => $daftarUjian->nilai
            ]
        ]);
    })->name('verify.hasil-ujian');


    });

