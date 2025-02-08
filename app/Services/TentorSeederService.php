<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Users\Tentor;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Akademik\MataPelajaran;
use App\DTOs\TentorData;
use App\Enums\GenderEnum;
use App\Enums\TentorStatusEnum;
use Faker\Generator;
use Illuminate\Support\Facades\Log;

class TentorSeederService
{
    public function __construct(
        private readonly Generator $faker
    ) {}

    public function createTentor(TentorData $data, User $user, Cabang $cabang): Tentor
    {
        try {
            return Tentor::create([
                'user_id' => $user->id,
                'jenis_kelamin' => $this->faker->randomElement(GenderEnum::cases())->value,
                'tanggal_lahir' => $this->generateBirthDate(),
                'alamat' => $this->faker->address(),
                'no_telepon' => $this->generatePhoneNumber(),
                'pendidikan_terakhir' => $data->pendidikanTerakhir,
                'jurusan' => $data->jurusan,
                'spesialisasi' => $data->spesialisasi,
                'cabang_id' => $cabang->id,
                'foto' => null,
                'status' => TentorStatusEnum::ACTIVE->value,
                'tanggal_bergabung' => now(),
                'tanggal_berakhir' => null,
                'catatan' => $this->faker->text(),
                'gaji_pokok' => $this->generateSalary(),
                'tunjangan' => $this->generateAllowance()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create tentor', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    private function generateBirthDate(): string
    {
        return $this->faker->dateTimeBetween('-40 years', '-25 years')->format('Y-m-d');
    }

    private function generatePhoneNumber(): string
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0852', '0853', '0811', '0814'];
        return $this->faker->randomElement($prefixes) . $this->faker->numerify('########');
    }

    private function generateSalary(): int
    {
        return $this->faker->numberBetween(3000000, 5000000);
    }

    private function generateAllowance(): int
    {
        return $this->faker->numberBetween(500000, 1000000);
    }
}
