<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Users\Siswa;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class SiswaSeeder extends Seeder
{
    private const DUMMY_COUNT = 50;

    private const AVAILABLE_SCHOOLS = [
        'SMAN 1 Jakarta',
        'SMAN 2 Jakarta',
        'SMAN 3 Jakarta',
        'SMAN 4 Jakarta',
        'SMAN 5 Jakarta',
        'SMA Labschool Jakarta',
        'SMAN 6 Jakarta',
        'SMAN 8 Jakarta',
        'SMAN 70 Jakarta',
        'SMAN 71 Jakarta'
    ];

    private const DEFAULT_STUDENTS = [
        [
            'nama_lengkap' => 'Siswa IPA',
            'email' => 'ipa@example.com',
            'kelas' => 'XII',
            'jurusan' => 'IPA',
            'asal_sekolah' => 'SMAN 1 Jakarta'
        ],
        [
            'nama_lengkap' => 'Siswa IPS',
            'email' => 'ips@example.com',
            'kelas' => 'XII',
            'jurusan' => 'IPS',
            'asal_sekolah' => 'SMAN 2 Jakarta'
        ],
        [
            'nama_lengkap' => 'Siswa Bahasa',
            'email' => 'bahasa@example.com',
            'kelas' => 'XII',
            'jurusan' => 'BAHASA',
            'asal_sekolah' => 'SMAN 3 Jakarta'
        ]
    ];

    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $this->command->info('Mulai seeding data siswa...');

        DB::transaction(function () use ($faker) {
            $kelasBimbels = KelasBimbel::all();

            if ($kelasBimbels->isEmpty()) {
                $this->command->error('Error: Tidak ada kelas bimbel yang tersedia.');
                return;
            }

            // Seed siswa default
            $this->seedDefaultStudents($faker, $kelasBimbels);

            // Seed siswa dummy
            $this->seedDummyStudents($faker, $kelasBimbels);
        });

        $this->command->info('Seeding data siswa selesai!');
    }

    private function seedDefaultStudents($faker, $kelasBimbels): void
    {
        foreach (self::DEFAULT_STUDENTS as $student) {
            $kelasBimbel = $kelasBimbels->where('tingkat_kelas', $student['kelas'])
                ->where('jurusan', $student['jurusan'])
                ->first();

            if (!$kelasBimbel) {
                $this->command->warn("Warning: Kelas bimbel untuk {$student['kelas']} {$student['jurusan']} tidak ditemukan.");
                continue;
            }

            $cabang = Cabang::all()->random();

            if (!$cabang) {
                $this->command->warn("Warning: Cabang tidak ditemukan.");
                continue;
            }

            $this->createSiswa($student, $faker, $kelasBimbel, $cabang);
            $this->command->info("Siswa {$student['nama_lengkap']} berhasil dibuat.");
        }
    }

    private function seedDummyStudents($faker, $kelasBimbels): void
    {
        for ($i = 1; $i <= self::DUMMY_COUNT; $i++) {
            $kelasBimbel = $kelasBimbels->random();
            $asalSekolah = $faker->randomElement(self::AVAILABLE_SCHOOLS);
            $cabang = Cabang::all()->random();

            $student = [
                'nama_lengkap' => "Siswa Test {$i}",
                'email' => "siswa{$i}@example.com",
                'kelas' => $kelasBimbel->tingkat_kelas,
                'jurusan' => $kelasBimbel->jurusan,
                'asal_sekolah' => $asalSekolah
            ];

            $this->createSiswa($student, $faker, $kelasBimbel, $cabang);
            $this->command->info("Siswa dummy {$i} berhasil dibuat.");
        }
    }

    private function createSiswa(array $student, $faker, $kelasBimbel, $cabang): void
    {
        Siswa::create([
            'nama_lengkap' => $student['nama_lengkap'],
            'email' => $student['email'],
            'password' => bcrypt('password123'),
            'jenis_kelamin' => $faker->randomElement(['L', 'P']),
            'tanggal_lahir' => $faker->dateTimeBetween('-20 years', '-15 years'),
            'alamat' => $faker->address(),
            'no_telepon' => $this->generatePhoneNumber($faker),
            'asal_sekolah' => $student['asal_sekolah'],
            'kelas' => $student['kelas'],
            'jurusan' => $student['jurusan'],
            'nama_wali' => $faker->name(),
            'no_telepon_wali' => $this->generatePhoneNumber($faker),
            'foto' => $faker->randomElement([
                'images/dummy/siswa/siswa-1.jpg',
                'images/dummy/siswa/siswa-2.jpg',
                'images/dummy/siswa/siswa-3.jpg',
                'images/dummy/siswa/siswa-4.jpg',
                'images/dummy/siswa/siswa-5.jpg'
            ]),
            'status' => 'aktif',
            'tanggal_bergabung' => now(),
            'tanggal_berakhir' => null,
            'catatan' => $faker->text(),
            'cabang_id' => $cabang->id,
            'kelas_bimbel_id' => $kelasBimbel->id,
        ]);
    }

    private function generatePhoneNumber($faker): string
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0852', '0853'];
        return $faker->randomElement($prefixes) . $faker->numerify('########');
    }
}
