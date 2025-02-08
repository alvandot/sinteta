<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Akademik\MataPelajaran;
use App\Models\Soal\PaketSoal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Illuminate\Support\Str;

class PaketSoalSeeder extends Seeder
{
    private const JENIS_PAKET = [
        'Latihan Soal' => 'latihan',
        'Ujian' => 'ujian',
        'Remedial' => 'remedial'
    ];
    private const TINGKAT = ['X', 'XI', 'XII'];
    private const LEVEL = ['Mudah', 'Sedang', 'Sulit'];

    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $this->command->info('Seeding paket soal...');

        DB::transaction(function () use ($faker) {
            $mataPelajarans = MataPelajaran::all();

            foreach ($mataPelajarans as $mapel) {
                $this->command->info("Membuat paket soal untuk {$mapel->nama_pelajaran}...");

                foreach (self::JENIS_PAKET as $label => $tipe) {
                    foreach (self::LEVEL as $level) {
                        $nama = "{$label} {$mapel->nama_pelajaran} - Level {$level}";

                        // Generate kode paket
                        $kodeMapel = Str::upper(substr($mapel->nama_pelajaran, 0, 3));
                        $kodeJenis = Str::upper(substr($tipe, 0, 2));
                        $timestamp = now()->format('His');
                        $kodePaket = "{$kodeMapel}{$kodeJenis}" . rand(1000, 9999) . $timestamp;

                        $deskripsi = "Paket soal ini mencakup materi:\n";
                        for ($i = 0; $i < 3; $i++) {
                            $deskripsi .= "- " . $faker->sentence() . "\n";
                        }
                        $deskripsi .= "Tujuan pembelajaran:\n";
                        for ($i = 0; $i < 2; $i++) {
                            $deskripsi .= ($i + 1) . ". " . $faker->sentence() . "\n";
                        }

                        PaketSoal::create([
                            'nama' => $nama,
                            'kode_paket' => $kodePaket,
                            'deskripsi' => $deskripsi,
                            'mata_pelajaran_id' => $mapel->id,
                            'tingkat' => $faker->randomElement(self::TINGKAT),
                            'tahun' => 2025,
                            'status' => 'published',
                            'tipe_soal' => $tipe
                        ]);

                        $this->command->info("Paket soal {$nama} berhasil dibuat.");
                    }
                }
            }

            // Membuat beberapa paket soal dummy tambahan
            $this->command->info('Membuat paket soal dummy tambahan...');

            for ($i = 1; $i <= 10; $i++) {
                $mapel = $mataPelajarans->random();
                $jenis = array_rand(self::JENIS_PAKET);
                $tipe = self::JENIS_PAKET[$jenis];
                $bab = $faker->numberBetween(1, 10);
                $nama = "{$jenis} {$mapel->nama_pelajaran} Bab {$bab}";

                // Generate kode paket untuk dummy
                $kodeMapel = Str::upper(substr($mapel->nama_pelajaran, 0, 3));
                $kodeJenis = Str::upper(substr($tipe, 0, 2));
                $timestamp = now()->format('His');
                $kodePaket = "{$kodeMapel}{$kodeJenis}D" . rand(1000, 9999) . $timestamp;

                $deskripsi = "Paket soal ini mencakup materi:\n";
                for ($j = 0; $j < 3; $j++) {
                    $deskripsi .= "- " . $faker->sentence() . "\n";
                }
                $deskripsi .= "Tujuan pembelajaran:\n";
                for ($j = 0; $j < 2; $j++) {
                    $deskripsi .= ($j + 1) . ". " . $faker->sentence() . "\n";
                }

                PaketSoal::create([
                    'nama' => $nama,
                    'kode_paket' => $kodePaket,
                    'deskripsi' => $deskripsi,
                    'mata_pelajaran_id' => $mapel->id,
                    'tingkat' => $faker->randomElement(self::TINGKAT),
                    'tahun' => 2025,
                    'status' => 'published',
                    'tipe_soal' => $tipe
                ]);

                $this->command->info("Paket soal dummy {$nama} berhasil dibuat.");
            }
        });

        $this->command->info('Seeding paket soal selesai!');
    }

    private function generateKodePaket(string $prefix, string $matpelId, string $tingkat): string
    {
        $randomNum = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $timestamp = now()->format('His'); // Menambahkan timestamp untuk memastikan keunikan
        return strtoupper($prefix . $matpelId . $tingkat . $randomNum . $timestamp);
    }

    private function createPaketSoal(string $nama, string $prefix, MataPelajaran $matpel, string $tingkat, string $tipe): void
    {
        $kodePaket = $this->generateKodePaket($prefix, $matpel->id, $tingkat);

        try {
            PaketSoal::create([
                'nama' => $nama,
                'kode_paket' => $kodePaket,
                'deskripsi' => $this->faker->text(300),
                'mata_pelajaran_id' => $matpel->id,
                'tingkat' => $tingkat,
                'tahun' => 2025,
                'status' => 'published',
                'tipe_soal' => $tipe,
            ]);

            $this->command->info("Paket soal {$nama} berhasil dibuat.");
        } catch (\Exception $e) {
            $this->command->error("Gagal membuat paket soal {$nama}: " . $e->getMessage());
        }
    }
}
