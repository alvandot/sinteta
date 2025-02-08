<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akademik\Absensi;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Users\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data jadwal belajar
        $jadwalBelajars = JadwalBelajar::with(['kelasBimbel.siswa', 'tentor'])->get();

        if ($jadwalBelajars->isEmpty()) {
            $this->command->error('Tidak ada data jadwal belajar! Silahkan jalankan seeder JadwalBelajar terlebih dahulu.');
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($jadwalBelajars as $jadwal) {
                // Generate absensi untuk 1 bulan terakhir
                $tanggalMulai = Carbon::now()->subMonth();
                $tanggalSekarang = Carbon::now();

                while ($tanggalMulai <= $tanggalSekarang) {
                    // Skip hari Minggu
                    if ($tanggalMulai->dayOfWeek !== Carbon::SUNDAY) {
                        $siswaKelas = $jadwal->kelasBimbel->siswa;

                        // Catatan pembelajaran untuk hari ini
                        $catatanPembelajaran = fake()->randomElement([
                            'Membahas materi bab 1 tentang aljabar',
                            'Latihan soal-soal persiapan ujian',
                            'Review materi sebelumnya dan pembahasan PR',
                            'Pembahasan soal-soal olimpiade',
                            'Praktikum dan eksperimen sederhana',
                            'Diskusi kelompok dan presentasi',
                            'Evaluasi pembelajaran mingguan',
                            'Pembahasan soal-soal UN tahun lalu',
                        ]);

                        foreach ($siswaKelas as $siswa) {
                            // Generate random status dengan probabilitas:
                            // - 70% hadir
                            // - 10% izin
                            // - 10% sakit
                            // - 10% alpha
                            $status = fake()->randomElement([
                                'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'hadir', // 70%
                                'izin',  // 10%
                                'sakit', // 10%
                                'alpha'  // 10%
                            ]);

                            // Generate keterangan jika tidak hadir
                            $keterangan = null;
                            if ($status !== 'hadir') {
                                $keterangan = match($status) {
                                    'izin' => fake()->randomElement([
                                        'Ada acara keluarga',
                                        'Mengikuti lomba di sekolah',
                                        'Ada kegiatan OSIS',
                                        'Izin pulang kampung',
                                    ]),
                                    'sakit' => fake()->randomElement([
                                        'Demam',
                                        'Flu dan batuk',
                                        'Sakit perut',
                                        'Migrain',
                                        'Radang tenggorokan',
                                    ]),
                                    'alpha' => fake()->randomElement([
                                        'Tidak ada keterangan',
                                        'Tidak bisa dihubungi',
                                        'Terlambat lebih dari 30 menit',
                                    ]),
                                    default => null
                                };
                            }

                            // Simpan absensi
                            Absensi::create([
                                'jadwal_belajar_id' => $jadwal->id,
                                'siswa_id' => $siswa->id,
                                'tentor_id' => $jadwal->tentor_id,
                                'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                                'status' => $status,
                                'keterangan' => $keterangan,
                                'catatan_pembelajaran' => $catatanPembelajaran,
                                'tanggal' => $tanggalMulai->format('Y-m-d'),
                            ]);
                        }
                    }

                    $tanggalMulai->addDay();
                }
            }

            DB::commit();
            $this->command->info('Data absensi berhasil di-seed!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
