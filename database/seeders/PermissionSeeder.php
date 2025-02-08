<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Permission groups and their permissions
     */
    private const PERMISSION_GROUPS = [
        'user' => [
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'export_users',
            'import_users',
        ],
        'role' => [
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
        ],
        'soal' => [
            'view_soal',
            'create_soal',
            'edit_soal',
            'delete_soal',
            'export_soal',
            'import_soal',
            'validate_soal',
        ],
        'ujian' => [
            'view_ujian',
            'create_ujian',
            'edit_ujian',
            'delete_ujian',
            'manage_ujian',
            'export_ujian',
            'import_ujian',
            'validate_ujian',
        ],
        'nilai' => [
            'view_nilai',
            'input_nilai',
            'edit_nilai',
            'delete_nilai',
            'export_nilai',
            'import_nilai',
            'validate_nilai',
        ],
    ];

    /**
     * Role definitions with their permissions
     */
    private const ROLE_DEFINITIONS = [
        'admin' => null, // null means all permissions
        'siswa' => [
            'view_soal',
            'view_ujian',
            'view_nilai',
        ],
        'tentor' => [
            'view_soal',
            'create_soal',
            'edit_soal',
            'delete_soal',
            'export_soal',
            'validate_soal',
            'view_ujian',
            'view_nilai',
            'input_nilai',
            'edit_nilai',
            'export_nilai',
        ],
        'kacap' => [
            'view_soal',
            'view_ujian',
            'create_ujian',
            'edit_ujian',
            'delete_ujian',
            'manage_ujian',
            'export_ujian',
            'validate_ujian',
            'view_nilai',
            'input_nilai',
            'edit_nilai',
            'delete_nilai',
            'export_nilai',
            'validate_nilai',
        ],
    ];

    public function run(): void
    {
        $this->command->info('Mulai seeding permissions dan roles...');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        try {
            \DB::beginTransaction();

            // Create permissions
            $allPermissions = [];
            foreach (self::PERMISSION_GROUPS as $group => $permissions) {
                $this->command->info("Creating {$group} permissions...");
                foreach ($permissions as $permission) {
                    $allPermissions[] = $permission;
                    Permission::create(['name' => $permission, 'group' => $group]);
                }
            }

            // Create roles and assign permissions
            foreach (self::ROLE_DEFINITIONS as $roleName => $permissions) {
                $this->command->info("Creating role: {$roleName}");
                $role = Role::create(['name' => $roleName]);

                // If permissions is null, assign all permissions (admin)
                $rolePermissions = $permissions === null ? $allPermissions : $permissions;
                $role->givePermissionTo($rolePermissions);
            }

            \DB::commit();
            $this->command->info('Permissions dan roles berhasil dibuat!');
        } catch (\Exception $e) {
            \DB::rollBack();
            $this->command->error('Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
