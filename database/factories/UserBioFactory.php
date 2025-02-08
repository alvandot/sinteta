<?php

namespace Database\Factories;

use App\Models\UserBio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserBioFactory extends Factory
{
    protected $model = UserBio::class;

    /**
     * Jenis kelamin yang tersedia
     */
    private const AVAILABLE_GENDERS = ['L', 'P'];

    /**
     * Agama yang tersedia
     */
    private const AVAILABLE_RELIGIONS = [
        'Islam',
        'Kristen',
        'Katolik',
        'Hindu',
        'Buddha',
        'Konghucu'
    ];

    /**
     * Golongan darah yang tersedia
     */
    private const AVAILABLE_BLOOD_TYPES = ['A', 'B', 'AB', 'O'];

    public function definition(): array
    {
        $gender = $this->faker->randomElement(self::AVAILABLE_GENDERS);

        return [
            'user_id' => User::factory(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-30 years', '-15 years')->format('Y-m-d'),
            'jenis_kelamin' => $gender,
            'agama' => $this->faker->randomElement(self::AVAILABLE_RELIGIONS),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->generatePhoneNumber(),
            'golongan_darah' => $this->faker->randomElement(self::AVAILABLE_BLOOD_TYPES),
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan nomor telepon Indonesia yang valid
     */
    protected function generatePhoneNumber(): string
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0852', '0853', '0811', '0814'];
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numberBetween(10000000, 99999999);

        return $prefix . $number;
    }

    /**
     * State untuk user bio dengan jenis kelamin tertentu
     */
    public function withGender(string $gender): static
    {
        if (!in_array($gender, self::AVAILABLE_GENDERS)) {
            throw new \InvalidArgumentException("Jenis kelamin '$gender' tidak valid");
        }

        return $this->state(['jenis_kelamin' => $gender]);
    }

    /**
     * State untuk user bio dengan agama tertentu
     */
    public function withReligion(string $religion): static
    {
        if (!in_array($religion, self::AVAILABLE_RELIGIONS)) {
            throw new \InvalidArgumentException("Agama '$religion' tidak valid");
        }

        return $this->state(['agama' => $religion]);
    }

    /**
     * State untuk user bio dengan golongan darah tertentu
     */
    public function withBloodType(string $bloodType): static
    {
        if (!in_array($bloodType, self::AVAILABLE_BLOOD_TYPES)) {
            throw new \InvalidArgumentException("Golongan darah '$bloodType' tidak valid");
        }

        return $this->state(['golongan_darah' => $bloodType]);
    }

    /**
     * State untuk user bio dengan foto
     */
    public function withPhoto(string $photoPath): static
    {
        return $this->state(['foto' => $photoPath]);
    }

    /**
     * State untuk user bio dengan user tertentu
     */
    public function forUser(User $user): static
    {
        return $this->state(['user_id' => $user->id]);
    }

    /**
     * State untuk user bio dengan rentang umur tertentu
     */
    public function withAgeRange(int $minAge, int $maxAge): static
    {
        return $this->state([
            'tanggal_lahir' => $this->faker->dateTimeBetween("-$maxAge years", "-$minAge years")->format('Y-m-d'),
        ]);
    }
}
