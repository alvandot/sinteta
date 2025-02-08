<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Role yang tersedia di sistem
     */
    private const AVAILABLE_ROLES = [
        'admin',     // Administrator
        'tentor',    // Tentor/Pengajar
        'siswa',     // Siswa/Peserta
        'akademik'  // Akademik
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding roles...');

        DB::transaction(function () {
            foreach (self::AVAILABLE_ROLES as $role) {
                DB::table('roles')->insert([
                    'name' => $role,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $this->command->info("Role {$role} berhasil dibuat.");
            }
        });

        $this->command->info('Seeding roles selesai!');
    }
}

