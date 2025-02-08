<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Jumlah cabang dummy yang akan dibuat
     */
    private const DUMMY_COUNT = 5;

    /**
     * Data cabang default
     */
    private const DEFAULT_BRANCHES = [
        [
            'nama' => 'Cabang Pusat',
            'kode_cabang' => 'CBG001',
            'alamat' => 'Jl. Raya Pusat No. 1',
            'kontak' => '021-1234567',
            'email' => 'pusat@cbt.test',
            'status' => 'active'
        ],
        [
            'nama' => 'Cabang Utara',
            'kode_cabang' => 'CBG002',
            'alamat' => 'Jl. Raya Utara No. 2',
            'kontak' => '021-2345678',
            'email' => 'utara@cbt.test',
            'status' => 'active'
        ],
        [
            'nama' => 'Cabang Selatan',
            'kode_cabang' => 'CBG003',
            'alamat' => 'Jl. Raya Selatan No. 3',
            'kontak' => '021-3456789',
            'email' => 'selatan@cbt.test',
            'status' => 'active'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding cabang...');

        DB::transaction(function () {
            // Create default branches
            $this->command->info('Membuat cabang default...');
            $this->createDefaultBranches();

            // Create dummy branches
            $this->command->info('Membuat cabang dummy...');
            $this->createDummyBranches();
        });

        $this->command->info('Seeding cabang selesai!');
    }

    /**
     * Create default branches
     */
    private function createDefaultBranches(): void
    {
        foreach (self::DEFAULT_BRANCHES as $branch) {
            DB::table('cabangs')->insert([
                'nama' => $branch['nama'],
                'kode_cabang' => $branch['kode_cabang'],
                'alamat' => $branch['alamat'],
                'kontak' => $branch['kontak'],
                'email' => $branch['email'],
                'status' => $branch['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Cabang {$branch['nama']} berhasil dibuat.");
        }
    }

    /**
     * Create dummy branches
     */
    private function createDummyBranches(): void
    {
        for ($i = 1; $i <= self::DUMMY_COUNT; $i++) {
            $nama = "Cabang Dummy " . $i;
            $kode = "CBG" . str_pad($i + 3, 3, '0', STR_PAD_LEFT);

            DB::table('cabangs')->insert([
                'nama' => $nama,
                'kode_cabang' => $kode,
                'alamat' => "Jl. Dummy No. {$i}",
                'kontak' => "021-" . str_pad($i, 7, '0', STR_PAD_LEFT),
                'email' => "dummy{$i}@cbt.test",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $this->command->info("Cabang {$nama} berhasil dibuat.");
        }
    }
}
