<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Jumlah mata pelajaran dummy yang akan dibuat
     */
    private const DUMMY_COUNT = 5;

    /**
     * Data mata pelajaran default
     */
    private const DEFAULT_SUBJECTS = [
        // IPA
        [
            'nama_pelajaran' => 'Matematika',
            'kode_pelajaran' => 'MAT001',
            'deskripsi' => 'Pelajaran tentang logika, aljabar, geometri, dan kalkulus',
            'kategori' => 'IPA',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'sedang',
            'kkm' => 70,
            'status' => 'active'
        ],
        [
            'nama_pelajaran' => 'Fisika',
            'kode_pelajaran' => 'FIS001',
            'deskripsi' => 'Pelajaran tentang materi, energi, dan fenomena alam',
            'kategori' => 'IPA',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'sulit',
            'kkm' => 70,
            'status' => 'active'
        ],
        [
            'nama_pelajaran' => 'Biologi',
            'kode_pelajaran' => 'BIO001',
            'deskripsi' => 'Pelajaran tentang makhluk hidup dan lingkungannya',
            'kategori' => 'IPA',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'sedang',
            'kkm' => 70,
            'status' => 'active'
        ],
        // IPS
        [
            'nama_pelajaran' => 'Ekonomi',
            'kode_pelajaran' => 'EKO001',
            'deskripsi' => 'Pelajaran tentang perilaku dan tindakan manusia dalam memenuhi kebutuhan hidupnya',
            'kategori' => 'IPS',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'sedang',
            'kkm' => 70,
            'status' => 'active'
        ],
        [
            'nama_pelajaran' => 'Geografi',
            'kode_pelajaran' => 'GEO001',
            'deskripsi' => 'Pelajaran tentang permukaan bumi dan fenomena yang terjadi di dalamnya',
            'kategori' => 'IPS',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'mudah',
            'kkm' => 70,
            'status' => 'active'
        ],
        // BAHASA
        [
            'nama_pelajaran' => 'Bahasa Indonesia',
            'kode_pelajaran' => 'BIN001',
            'deskripsi' => 'Pelajaran tentang keterampilan berbahasa Indonesia yang baik dan benar',
            'kategori' => 'BAHASA',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'mudah',
            'kkm' => 70,
            'status' => 'active'
        ],
        [
            'nama_pelajaran' => 'Bahasa Inggris',
            'kode_pelajaran' => 'BIG001',
            'deskripsi' => 'Pelajaran tentang keterampilan berbahasa Inggris untuk komunikasi global',
            'kategori' => 'BAHASA',
            'tingkat_kelas' => 'X',
            'level_kesulitan' => 'sedang',
            'kkm' => 70,
            'status' => 'active'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding mata pelajaran...');

        DB::transaction(function () {
            // Create default subjects
            $this->command->info('Membuat mata pelajaran default...');
            $this->createDefaultSubjects();

            // Create dummy subjects
            $this->command->info('Membuat mata pelajaran dummy...');
            $this->createDummySubjects();
        });

        $this->command->info('Seeding mata pelajaran selesai!');
    }

    /**
     * Create default subjects
     */
    private function createDefaultSubjects(): void
    {
        foreach (self::DEFAULT_SUBJECTS as $subject) {
            DB::table('mata_pelajarans')->insert([
                'nama_pelajaran' => $subject['nama_pelajaran'],
                'kode_pelajaran' => $subject['kode_pelajaran'],
                'deskripsi' => $subject['deskripsi'],
                'kategori' => $subject['kategori'],
                'tingkat_kelas' => $subject['tingkat_kelas'],
                'level_kesulitan' => $subject['level_kesulitan'],
                'kkm' => $subject['kkm'],
                'status' => $subject['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Mata pelajaran {$subject['nama_pelajaran']} berhasil dibuat.");
        }
    }

    /**
     * Create dummy subjects
     */
    private function createDummySubjects(): void
    {
        $categories = ['IPA', 'IPS', 'BAHASA'];
        $grades = ['X', 'XI', 'XII'];
        $difficulties = ['mudah', 'sedang', 'sulit'];

        for ($i = 1; $i <= self::DUMMY_COUNT; $i++) {
            $category = $categories[array_rand($categories)];
            $grade = $grades[array_rand($grades)];
            $difficulty = $difficulties[array_rand($difficulties)];

            $nama = "Mata Pelajaran Dummy " . $i;
            $kode = "MPD" . str_pad($i, 3, '0', STR_PAD_LEFT);

            DB::table('mata_pelajarans')->insert([
                'nama_pelajaran' => $nama,
                'kode_pelajaran' => $kode,
                'deskripsi' => "Deskripsi untuk {$nama}",
                'kategori' => $category,
                'tingkat_kelas' => $grade,
                'level_kesulitan' => $difficulty,
                'kkm' => rand(65, 75),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Mata pelajaran {$nama} berhasil dibuat.");
        }
    }
}
