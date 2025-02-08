<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Tabel yang akan dikosongkan sebelum seeding
     */
    private const TABLES_TO_TRUNCATE = [
        // Master Data
        'cabangs',
        'mata_pelajarans',
        'kelas_bimbels',

        // User Data
        'users',
        'user_bios',
        'tentors',
        'siswas',
        'mata_pelajaran_tentors',

        // Academic Data
        'jadwal_belajars',

        // Exam Data
        'paket_soals',
        'soals',
        'ujians',
        'daftar_ujian_siswas',

        // Ruangan
        'ruangans',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Mulai seeding database...');

        // Truncate all tables
        $this->truncateAllTables();

        DB::transaction(function () {
            // 1. Seed Permissions & Roles
            $this->command->info('Seeding permissions & roles...');
            $this->call([
                PermissionSeeder::class,     // Permission & Role harus pertama
            ]);

            // 2. Seed Master Data
            $this->command->info('Seeding master data...');
            $this->call([
                CabangSeeder::class,         // Cabang diperlukan untuk data lain
                MataPelajaranSeeder::class,  // Mata pelajaran diperlukan untuk tentor
                KelasBimbelSeeder::class,    // Kelas diperlukan untuk siswa
                RuanganSeeder::class,        // Ruangan diperlukan untuk jadwal
            ]);

            // 3. Seed User Data
            $this->command->info('Seeding user data...');
            $this->call([
                UserSeeder::class,               // User harus ada sebelum bio
                UserBioSeeder::class,            // Bio user
                TentorSeeder::class,             // Tentor
                SiswaSeeder::class,              // Siswa
                MataPelajaranTentorSeeder::class // Relasi mata pelajaran-tentor
            ]);

            // 4. Seed Academic Data
            $this->command->info('Seeding academic data...');
            $this->call([
                JadwalBelajarSeeder::class,  // Jadwal belajar
            ]);

            // 5. Seed Exam Data
            $this->command->info('Seeding exam data...');
            $this->call([
                PaketSoalSeeder::class,         // Paket soal harus ada sebelum soal
                SoalSeeder::class,              // Soal
                UjianSeeder::class,             // Ujian harus ada sebelum daftar ujian
                DaftarUjianSiswaSeeder::class   // Daftar ujian siswa
            ]);

            // 6. Seed Ruangan
            $this->command->info('Seeding ruangan data...');
            $this->call([
                RuanganSeeder::class,        // Ruangan
            ]);

            // 7. Seed Jadwal
            $this->command->info('Seeding jadwal data...');
            $this->call([
                JadwalBelajarSeeder::class,  // Jadwal belajar
            ]);

            // 8. Seed Absensi
            $this->command->info('Seeding absensi data...');
            $this->call([
                AbsensiSeeder::class,
            ]);
        });

        $this->command->info('Seeding database selesai!');
    }

    /**
     * Truncate all tables before seeding
     */
    private function truncateAllTables(): void
    {
        $this->command->info('Mengosongkan tabel...');

        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate each table
        foreach (self::TABLES_TO_TRUNCATE as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->info("Tabel {$table} dikosongkan.");
            } else {
                $this->command->warn("Tabel {$table} tidak ditemukan.");
            }
        }

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();

        $this->command->info('Semua tabel berhasil dikosongkan.');
    }
}
