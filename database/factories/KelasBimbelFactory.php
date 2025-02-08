<?php

namespace Database\Factories;

use App\Models\KelasBimbel;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasBimbelFactory extends Factory
{
    protected $model = KelasBimbel::class;

    /**
     * Status yang tersedia untuk kelas bimbel
     */
    private const AVAILABLE_STATUSES = ['active', 'inactive', 'archived'];

    /**
     * Tingkat kelas yang tersedia
     */
    private const AVAILABLE_GRADES = ['X', 'XI', 'XII'];

    /**
     * Program bimbel yang tersedia
     */
    private const AVAILABLE_PROGRAMS = [
        'Reguler',
        'Intensif',
        'Private',
        'Online'
    ];

    public function definition(): array
    {
        $grade = $this->faker->randomElement(self::AVAILABLE_GRADES);
        $program = $this->faker->randomElement(self::AVAILABLE_PROGRAMS);

        return [
            'nama_kelas' => $this->generateClassName($grade, $program),
            'deskripsi' => $this->generateDescription($grade, $program),
            'tingkat_kelas' => $grade,
            'program_bimbel' => $program,
            'kapasitas' => $this->faker->numberBetween(10, 30),
            'biaya_pendaftaran' => $this->faker->numberBetween(100000, 500000),
            'biaya_bulanan' => $this->faker->numberBetween(500000, 2000000),
            'tanggal_mulai' => $this->faker->dateTimeBetween('now', '+1 month'),
            'tanggal_selesai' => $this->faker->dateTimeBetween('+5 months', '+6 months'),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan nama kelas yang valid
     */
    protected function generateClassName(string $grade, string $program): string
    {
        $uniqueCode = strtoupper($this->faker->lexify('??')) . $this->faker->numberBetween(1, 9);
        return "Kelas {$grade} {$program} - {$uniqueCode}";
    }

    /**
     * Menghasilkan deskripsi yang valid
     */
    protected function generateDescription(string $grade, string $program): string
    {
        $descriptionParts = [
            "Kelas bimbingan belajar untuk siswa kelas {$grade}",
            "Program: {$program}",
            'Fasilitas:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence(),
            'Target Pembelajaran:',
            '1. ' . $this->faker->sentence(),
            '2. ' . $this->faker->sentence()
        ];

        return implode("\n", $descriptionParts);
    }

    /**
     * State untuk kelas dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk kelas dengan tingkat tertentu
     */
    public function withGrade(string $grade): static
    {
        if (!in_array($grade, self::AVAILABLE_GRADES)) {
            throw new \InvalidArgumentException("Tingkat kelas '$grade' tidak valid");
        }

        return $this->state(['tingkat_kelas' => $grade]);
    }

    /**
     * State untuk kelas dengan program tertentu
     */
    public function withProgram(string $program): static
    {
        if (!in_array($program, self::AVAILABLE_PROGRAMS)) {
            throw new \InvalidArgumentException("Program '$program' tidak valid");
        }

        return $this->state(['program_bimbel' => $program]);
    }

    /**
     * State untuk kelas dengan kapasitas tertentu
     */
    public function withCapacity(int $capacity): static
    {
        if ($capacity < 1 || $capacity > 50) {
            throw new \InvalidArgumentException("Kapasitas harus antara 1 dan 50");
        }

        return $this->state(['kapasitas' => $capacity]);
    }

    /**
     * State untuk kelas dengan biaya tertentu
     */
    public function withFees(int $registrationFee, int $monthlyFee): static
    {
        if ($registrationFee < 0 || $monthlyFee < 0) {
            throw new \InvalidArgumentException("Biaya tidak boleh negatif");
        }

        return $this->state([
            'biaya_pendaftaran' => $registrationFee,
            'biaya_bulanan' => $monthlyFee
        ]);
    }

    /**
     * State untuk kelas dengan rentang tanggal tertentu
     */
    public function withDateRange(\DateTime $startDate, \DateTime $endDate): static
    {
        if ($startDate >= $endDate) {
            throw new \InvalidArgumentException("Tanggal mulai harus lebih awal dari tanggal selesai");
        }

        return $this->state([
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate
        ]);
    }
}
