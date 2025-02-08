<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Jumlah user dummy yang akan dibuat
     */
    private const DUMMY_COUNT = [
        'admin' => 3,
        'tentor' => 5,
        'kacap' => 2
    ];

    /**
     * Status yang tersedia
     */
    private const AVAILABLE_STATUSES = [
        'active',
        'inactive',
        'suspended'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding users...');

        DB::transaction(function () {
            // Create admin users
            $this->command->info('Membuat user admin...');
            $this->createAdmins();

            // Create tentor users
            $this->command->info('Membuat user tentor...');
            $this->createTentors();

            // Create kacap users
            $this->command->info('Membuat user kacap...');
            $this->createKacap();
        });

        $this->command->info('Seeding users selesai!');
    }

    /**
     * Create admin users
     */
    private function createAdmins(): void
    {
        $faker = Factory::create('id_ID');

        // Create default admin
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@cbt.test',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Assign admin role
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        DB::table('model_has_roles')->insert([
            'role_id' => $adminRoleId,
            'model_type' => 'App\\Models\\User',
            'model_id' => $adminId
        ]);

        $this->command->info('Admin default berhasil dibuat.');

        // Create dummy admins
        for ($i = 1; $i <= self::DUMMY_COUNT['admin']; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => "Admin {$i}",
                'email' => "admin{$i}@cbt.test",
                'password' => Hash::make('password123'),
                'status' => $faker->randomElement(self::AVAILABLE_STATUSES),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Assign admin role
            DB::table('model_has_roles')->insert([
                'role_id' => $adminRoleId,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId
            ]);

            $this->command->info("Admin {$i} berhasil dibuat.");
        }
    }

    /**
     * Create tentor users
     */
    private function createTentors(): void
    {
        $faker = Factory::create('id_ID');
        $tentorRoleId = DB::table('roles')->where('name', 'tentor')->value('id');

        for ($i = 1; $i <= self::DUMMY_COUNT['tentor']; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => "Tentor {$i}",
                'email' => "tentor{$i}@cbt.test",
                'password' => Hash::make('password123'),
                'status' => $faker->randomElement(self::AVAILABLE_STATUSES),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Assign tentor role
            DB::table('model_has_roles')->insert([
                'role_id' => $tentorRoleId,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId
            ]);

            $this->command->info("Tentor {$i} berhasil dibuat.");
        }
    }

    /**
     * Create kacap users
     */
    private function createKacap(): void
    {
        $faker = Factory::create('id_ID');
        $kacapRoleId = DB::table('roles')->where('name', 'kacap')->value('id');

        // Create default kacap
        $kacapId = DB::table('users')->insertGetId([
            'name' => 'Kepala Cabang',
            'email' => 'kacap@cbt.test',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Assign kacap role
        DB::table('model_has_roles')->insert([
            'role_id' => $kacapRoleId,
            'model_type' => 'App\\Models\\User',
            'model_id' => $kacapId
        ]);

        $this->command->info('Kepala Cabang default berhasil dibuat.');

        // Create dummy kacap users
        for ($i = 1; $i <= self::DUMMY_COUNT['kacap']; $i++) {
            $userId = DB::table('users')->insertGetId([
                'name' => "Kepala Cabang {$i}",
                'email' => "kacap{$i}@cbt.test",
                'password' => Hash::make('password123'),
                'status' => $faker->randomElement(self::AVAILABLE_STATUSES),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Assign kacap role
            DB::table('model_has_roles')->insert([
                'role_id' => $kacapRoleId,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId
            ]);

            $this->command->info("Kepala Cabang {$i} berhasil dibuat.");
        }
    }
}
