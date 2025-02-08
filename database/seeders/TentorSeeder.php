<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Constants\TentorConstants;
use App\DTOs\TentorData;
use App\Services\TentorSeederService;
use App\Models\Cabang;
use App\Models\Users\Tentor;
use App\Models\Akademik\MataPelajaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class TentorSeeder extends Seeder
{
    private const DUMMY_COUNT = 5;

    private Collection $defaultTentors;
    private \Faker\Generator $faker;
    private TentorSeederService $tentorService;

    public function __construct(TentorSeederService $tentorService)
    {
        $this->faker = Factory::create('id_ID');
        $this->tentorService = $tentorService;
        $this->defaultTentors = $this->initializeDefaultTentors();
    }

    public function run(): void
    {
        $this->command->info('Seeding tentor...');

        try {
            DB::transaction(function () {
                $this->createDefaultTentors();
                $this->createDummyTentors();
            });

            $this->command->info('Seeding tentor selesai!');
        } catch (\Exception $e) {
            Log::error('Tentor seeding failed', ['error' => $e->getMessage()]);
            $this->command->error("Error seeding tentor: {$e->getMessage()}");
            throw $e;
        }
    }

    private function initializeDefaultTentors(): Collection
    {
        return collect([
            new TentorData(
                'Tentor Matematika',
                'matematika@cbt.test',
                'Matematika',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['MATEMATIKA'],
                TentorConstants::SPECIALIZATIONS['MATEMATIKA']
            ),
            new TentorData(
                'Tentor Fisika',
                'fisika@cbt.test',
                'Fisika',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['FISIKA'],
                TentorConstants::SPECIALIZATIONS['FISIKA']
            ),
            new TentorData(
                'Tentor Biologi',
                'biologi@cbt.test',
                'Biologi',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['BIOLOGI'],
                TentorConstants::SPECIALIZATIONS['BIOLOGI']
            ),
            new TentorData(
                'Tentor Bahasa Indonesia',
                'indo@cbt.test',
                'Bahasa Indonesia',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['INDO'],
                TentorConstants::SPECIALIZATIONS['INDO']
            ),
            new TentorData(
                'Tentor Bahasa Inggris',
                'inggris@cbt.test',
                'Bahasa Inggris',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['INGGRIS'],
                TentorConstants::SPECIALIZATIONS['INGGRIS']
            ),
            new TentorData(
                'Tentor Akuntansi',
                'akuntansi@cbt.test',
                'Akuntansi',
                TentorConstants::EDUCATION_LEVELS['S2'],
                TentorConstants::MAJORS['EKONOMI'],
                TentorConstants::SPECIALIZATIONS['EKONOMI']
            )
        ]);
    }

    private function createDefaultTentors(): void
    {
        $this->command->info('Membuat tentor default...');

        $this->defaultTentors->each(function (TentorData $tentorData) {
            $this->createSingleTentor($tentorData);
        });
    }

    private function createSingleTentor(TentorData $tentorData): void
    {
        $mataPelajaran = $this->findMataPelajaran($tentorData->mataPelajaran);
        $cabang = $this->getRandomCabang();

        // Buat user baru jika belum ada
        $user = $this->findOrCreateTentorUser($tentorData);

        if (!$this->validatePrerequisites($mataPelajaran, $cabang, $user, $tentorData)) {
            return;
        }

        $this->tentorService->createTentor($tentorData, $user, $cabang);
        $this->command->info("Tentor {$tentorData->name} berhasil dibuat.");
    }

    private function findOrCreateTentorUser(TentorData $tentorData): User
    {
        $user = User::where('email', $tentorData->email)->first();

        if (!$user) {
            $user = $this->createTentorUser($tentorData);
            $this->command->info("User account untuk {$tentorData->name} berhasil dibuat.");
        }

        // Pastikan user memiliki role tentor
        if (!$user->hasRole('tentor')) {
            $user->assignRole('tentor');
        }

        return $user;
    }

    private function createTentorUser(TentorData $tentorData): User
    {
        try {
            return DB::transaction(function () use ($tentorData) {
                $user = User::create([
                    'name' => $tentorData->name,
                    'email' => $tentorData->email,
                    'password' => Hash::make('password'), // Default password
                    'email_verified_at' => now(),
                ]);

                $tentorRole = Role::where('name', 'tentor')->firstOrFail();
                $user->assignRole($tentorRole);

                return $user;
            });
        } catch (\Exception $e) {
            Log::error('Failed to create tentor user', [
                'error' => $e->getMessage(),
                'data' => $tentorData
            ]);
            throw $e;
        }
    }

    private function findMataPelajaran(string $nama): ?MataPelajaran
    {
        return MataPelajaran::where('nama_pelajaran', $nama)->first();
    }

    private function getRandomCabang(): ?Cabang
    {
        return Cabang::inRandomOrder()->first();
    }

    private function validatePrerequisites(?MataPelajaran $mataPelajaran, ?Cabang $cabang, ?User $user, TentorData $tentorData): bool
    {
        if (!$mataPelajaran || !$cabang) {
            $this->command->warn("Mata pelajaran {$tentorData->mataPelajaran} atau cabang tidak ditemukan.");
            return false;
        }

        if (!$user) {
            $this->command->error("Gagal membuat user untuk {$tentorData->name}");
            return false;
        }

        return true;
    }

    private function createDummyTentors(): void
    {
        $this->command->info('Membuat tentor dummy...');

        $tentorRole = $this->getTentorRole();
        if (!$tentorRole) {
            return;
        }

        $users = $this->getTentorUsers();
        if ($users->isEmpty()) {
            return;
        }

        $this->createDummyTentorRecords($users);
    }

    private function getTentorRole(): ?Role
    {
        $role = Role::where('name', 'tentor')->first();
        if (!$role) {
            $this->command->error('Role tentor tidak ditemukan.');
        }
        return $role;
    }

    private function getTentorUsers(): Collection
    {
        $users = User::role('tentor')->get();
        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user tentor yang tersedia.');
        }
        return $users;
    }

    private function createDummyTentorRecords(Collection $users): void
    {
        $users->each(function ($user) {
            if (!Tentor::where('user_id', $user->id)->exists()) {
                $this->createDummyTentorRecord($user);
            }
        });
    }

    private function createDummyTentorRecord(User $user): void
    {
        // Implementasi pembuatan record dummy tentor
        // ... kode untuk membuat dummy tentor ...
    }
}
