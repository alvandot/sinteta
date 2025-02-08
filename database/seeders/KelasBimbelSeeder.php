<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasBimbelSeeder extends Seeder
{
    /**
     * Jumlah kelas dummy yang akan dibuat
     */
    private const DUMMY_COUNT = 5;

    /**
     * Data kelas default
     */
    private const DEFAULT_CLASSES = [
        // Kelas IPA
        [
            'nama_kelas' => 'Kelas X IPA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPA kelas X',
            'tingkat_kelas' => 'X',
            'jurusan' => 'IPA',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XI IPA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPA kelas XI',
            'tingkat_kelas' => 'XI',
            'jurusan' => 'IPA',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XII IPA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPA kelas XII',
            'tingkat_kelas' => 'XII',
            'jurusan' => 'IPA',
            'program_bimbel' => 'Intensif',
            'kapasitas' => 15,
            'biaya_pendaftaran' => 300000,
            'biaya_bulanan' => 750000
        ],
        // Kelas IPS
        [
            'nama_kelas' => 'Kelas X IPS',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPS kelas X',
            'tingkat_kelas' => 'X',
            'jurusan' => 'IPS',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XI IPS',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPS kelas XI',
            'tingkat_kelas' => 'XI',
            'jurusan' => 'IPS',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XII IPS',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa IPS kelas XII',
            'tingkat_kelas' => 'XII',
            'jurusan' => 'IPS',
            'program_bimbel' => 'Intensif',
            'kapasitas' => 15,
            'biaya_pendaftaran' => 300000,
            'biaya_bulanan' => 750000
        ],
        // Kelas BAHASA
        [
            'nama_kelas' => 'Kelas X BAHASA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa BAHASA kelas X',
            'tingkat_kelas' => 'X',
            'jurusan' => 'BAHASA',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XI BAHASA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa BAHASA kelas XI',
            'tingkat_kelas' => 'XI',
            'jurusan' => 'BAHASA',
            'program_bimbel' => 'Reguler',
            'kapasitas' => 20,
            'biaya_pendaftaran' => 250000,
            'biaya_bulanan' => 500000
        ],
        [
            'nama_kelas' => 'Kelas XII BAHASA',
            'deskripsi' => 'Kelas bimbingan belajar untuk siswa BAHASA kelas XII',
            'tingkat_kelas' => 'XII',
            'jurusan' => 'BAHASA',
            'program_bimbel' => 'Intensif',
            'kapasitas' => 15,
            'biaya_pendaftaran' => 300000,
            'biaya_bulanan' => 750000
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding kelas bimbel...');

        DB::transaction(function () {
            // Get default cabang
            $cabangId = DB::table('cabangs')->where('nama', 'Cabang Pusat')->value('id');
            if (!$cabangId) {
                $this->command->error('Cabang Pusat tidak ditemukan!');
                return;
            }

            // Create default classes
            $this->command->info('Membuat kelas bimbel default...');
            $this->createDefaultClasses($cabangId);

            // Create dummy classes
            $this->command->info('Membuat kelas bimbel dummy...');
            $this->createDummyClasses($cabangId);
        });

        $this->command->info('Seeding kelas bimbel selesai!');
    }

    /**
     * Create default classes
     */
    private function createDefaultClasses(int $cabangId): void
    {
        foreach (self::DEFAULT_CLASSES as $class) {
            DB::table('kelas_bimbels')->insert([
                'nama_kelas' => $class['nama_kelas'],
                'cabang_id' => $cabangId,
                'deskripsi' => $class['deskripsi'],
                'tingkat_kelas' => $class['tingkat_kelas'],
                'jurusan' => $class['jurusan'],
                'program_bimbel' => $class['program_bimbel'],
                'kapasitas' => $class['kapasitas'],
                'biaya_pendaftaran' => $class['biaya_pendaftaran'],
                'biaya_bulanan' => $class['biaya_bulanan'],
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addYear(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Kelas {$class['nama_kelas']} berhasil dibuat.");
        }
    }

    /**
     * Create dummy classes
     */
    private function createDummyClasses(int $cabangId): void
    {
        $grades = ['X', 'XI', 'XII'];
        $majors = ['IPA', 'IPS', 'BAHASA'];
        $programs = ['Reguler', 'Intensif', 'Private'];

        for ($i = 1; $i <= self::DUMMY_COUNT; $i++) {
            $grade = $grades[array_rand($grades)];
            $major = $majors[array_rand($majors)];
            $program = $programs[array_rand($programs)];

            $nama = "Kelas Dummy {$grade} {$major} {$i}";

            DB::table('kelas_bimbels')->insert([
                'nama_kelas' => $nama,
                'cabang_id' => $cabangId,
                'deskripsi' => "Kelas bimbingan belajar dummy untuk {$nama}",
                'tingkat_kelas' => $grade,
                'jurusan' => $major,
                'program_bimbel' => $program,
                'kapasitas' => rand(15, 25),
                'biaya_pendaftaran' => rand(200000, 300000),
                'biaya_bulanan' => rand(500000, 750000),
                'tanggal_mulai' => now(),
                'tanggal_selesai' => now()->addYear(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Kelas {$nama} berhasil dibuat.");
        }
    }
}
