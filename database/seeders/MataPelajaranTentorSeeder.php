<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Users\Tentor;
use App\Models\Akademik\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Faker\Generator;
use Faker\Factory;

class MataPelajaranTentorSeeder extends Seeder
{
    private const MAPEL_PER_TENTOR = 2;
    private const AVAILABLE_STATUSES = ['aktif', 'nonaktif'];
    private const EDUCATION_LEVELS = ['SMA', 'SMP'];
    private const MIN_YEARS = 1;
    private const MAX_YEARS = 10;

    private Generator $faker;

    public function run(): void
    {
        $this->faker = Factory::create('id_ID');

        $this->command->info('Memulai seeding mata pelajaran tentor...');

        DB::transaction(function () {
            $tentors = $this->getTentors();
            $mataPelajarans = $this->getMataPelajarans();

            if ($tentors->isEmpty() || $mataPelajarans->isEmpty()) {
                return;
            }

            $this->bulkInsertMataPelajaranTentors($tentors, $mataPelajarans);
        });

        $this->command->info('Seeding mata pelajaran tentor selesai!');
    }

    private function getTentors(): Collection
    {
        $tentors = Tentor::all();

        if ($tentors->isEmpty()) {
            $this->command->error('Tidak ada tentor yang tersedia.');
        }

        return $tentors;
    }

    private function getMataPelajarans(): Collection
    {
        $mataPelajarans = MataPelajaran::all();

        if ($mataPelajarans->isEmpty()) {
            $this->command->error('Tidak ada mata pelajaran yang tersedia.');
        }

        return $mataPelajarans;
    }

    private function bulkInsertMataPelajaranTentors(Collection $tentors, Collection $mataPelajarans): void
    {
        $insertData = [];
        $now = now();

        foreach ($tentors as $tentor) {
            $selectedMapels = $mataPelajarans->random(self::MAPEL_PER_TENTOR);

            foreach ($selectedMapels as $mapel) {
                $insertData[] = [
                    'tentor_id' => $tentor->id,
                    'mata_pelajaran_id' => $mapel->id,
                    'status' => $this->faker->randomElement(self::AVAILABLE_STATUSES),
                    'catatan' => $this->generateNotes($mapel),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $this->command->info("Mata pelajaran {$mapel->nama_pelajaran} ditugaskan ke tentor {$tentor->nama_lengkap}");
            }
        }

        // Bulk insert untuk mengurangi jumlah query
        DB::table('mata_pelajaran_tentors')->insert($insertData);
    }

    private function generateNotes(MataPelajaran $mapel): string
    {
        $notes = [
            sprintf(
                "Pengalaman mengajar %s selama %d tahun",
                $mapel->nama_pelajaran,
                $this->faker->numberBetween(self::MIN_YEARS, self::MAX_YEARS)
            ),
            sprintf(
                "Spesialisasi di bidang %s untuk tingkat %s",
                $mapel->nama_pelajaran,
                $this->faker->randomElement(self::EDUCATION_LEVELS)
            ),
            sprintf("Memiliki sertifikasi pengajaran %s", $mapel->nama_pelajaran),
            sprintf("Lulusan terbaik jurusan %s", $mapel->nama_pelajaran),
        ];

        return $this->faker->randomElement($notes);
    }
}
