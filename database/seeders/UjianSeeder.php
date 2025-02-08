<?php

namespace Database\Seeders;

use App\Models\Akademik\Ujian;
use App\Models\Soal\PaketSoal;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UjianSeeder extends Seeder
{
    private const DUMMY_COUNT = 20;
    private const AVAILABLE_TYPES = [
        'ulangan_harian',
        'ujian_tengah_semester',
        'ujian_akhir_semester',
        'remedial',
        'try_out'
    ];

    public function run(): void
    {
        $this->command->info('Memulai seeding ujian...');

        DB::transaction(function () {
            $paketSoals = PaketSoal::where('status', 'published')->get();
            if ($paketSoals->isEmpty()) {
                $this->command->error('Tidak ada paket soal yang tersedia.');
                return;
            }

            $kelasBimbels = KelasBimbel::where('status', 'active')->get();
            if ($kelasBimbels->isEmpty()) {
                $this->command->error('Tidak ada kelas bimbel yang tersedia.');
                return;
            }

            // Buat ujian default untuk setiap kelas dan tipe
            foreach ($kelasBimbels as $kelasBimbel) {
                foreach (self::AVAILABLE_TYPES as $type) {
                    $paketSoal = $paketSoals->random();
                    $tanggalUjian = now()->addDays(rand(1, 365))->format('Y-m-d');
                    $waktuMulai = '08:00:00';
                    $waktuSelesai = '10:00:00';

                    Ujian::create([
                        'nama' => "Ujian {$type} - {$kelasBimbel->nama}",
                        'deskripsi' => "Ujian {$type} untuk kelas {$kelasBimbel->nama}",
                        'tanggal_ujian' => $tanggalUjian,
                        'waktu_mulai' => $waktuMulai,
                        'waktu_selesai' => $waktuSelesai,
                        'durasi' => 120,
                        'paket_soal_id' => $paketSoal->id,
                        'mata_pelajaran_id' => $paketSoal->mata_pelajaran_id,
                        'kelas_id' => $kelasBimbel->id,
                        'status' => 'aktif',
                    ]);
                }
            }

            // Buat ujian dummy tambahan
            for ($i = 1; $i <= self::DUMMY_COUNT; $i++) {
                $paketSoal = $paketSoals->random();
                $kelasBimbel = $kelasBimbels->random();
                $tanggalUjian = now()->addDays(rand(366, 730))->format('Y-m-d');

                Ujian::create([
                    'nama' => "Ujian Dummy #{$i}",
                    'deskripsi' => "Ujian dummy untuk testing #{$i}",
                    'tanggal_ujian' => $tanggalUjian,
                    'waktu_mulai' => '08:00:00',
                    'waktu_selesai' => '10:00:00',
                    'durasi' => 120,
                    'paket_soal_id' => $paketSoal->id,
                    'mata_pelajaran_id' => $paketSoal->mata_pelajaran_id,
                    'kelas_id' => $kelasBimbel->id,
                    'status' => 'aktif',
                ]);
            }
        });

        $this->command->info('Seeding ujian selesai!');
    }
}
