<?php

namespace Database\Factories\Akademik;

use App\Models\Akademik\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class MataPelajaranFactory extends Factory
{
    protected $model = MataPelajaran::class;

    /**
     * Status yang tersedia untuk mata pelajaran
     */
    private const AVAILABLE_STATUSES = ['active', 'inactive'];

    /**
     * Tingkat kesulitan yang tersedia
     */
    private const AVAILABLE_DIFFICULTIES = ['mudah', 'sedang', 'sulit'];

    /**
     * Kategori mata pelajaran yang tersedia
     */
    private const AVAILABLE_CATEGORIES = [
        'IPA' => [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi'
        ],
        'IPS' => [
            'Ekonomi',
            'Geografi',
            'Sejarah',
            'Sosiologi'
        ],
        'BAHASA' => [
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Bahasa Jepang',
            'Bahasa Arab'
        ]
    ];

    /**
     * Tingkat kelas yang tersedia
     */
    private const AVAILABLE_GRADES = ['X', 'XI', 'XII'];

    public function definition(): array
    {
        $category = $this->faker->randomElement(array_keys(self::AVAILABLE_CATEGORIES));
        $name = $this->faker->randomElement(self::AVAILABLE_CATEGORIES[$category]);

        return [
            'nama_pelajaran' => $name,
            'kode_pelajaran' => $this->generateKodePelajaran($name),
            'deskripsi' => $this->generateDescription($name),
            'kategori' => $category,
            'tingkat_kelas' => $this->faker->randomElement(self::AVAILABLE_GRADES),
            'level_kesulitan' => $this->faker->randomElement(self::AVAILABLE_DIFFICULTIES),
            'kkm' => $this->faker->numberBetween(65, 80),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan kode pelajaran yang unik
     */
    protected function generateKodePelajaran(string $name): string
    {
        $prefix = strtoupper(substr(str_replace(' ', '', $name), 0, 3));
        $random = $this->faker->unique()->numberBetween(100, 999);
        return "{$prefix}{$random}";
    }

    /**
     * Menghasilkan deskripsi yang valid
     */
    protected function generateDescription(string $name): string
    {
        $descriptionParts = [
            "Mata pelajaran {$name} mencakup:",
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence(),
            'Tujuan pembelajaran:',
            '1. ' . $this->faker->sentence(),
            '2. ' . $this->faker->sentence()
        ];

        return implode("\n", $descriptionParts);
    }

    /**
     * State untuk mata pelajaran dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk mata pelajaran dengan level kesulitan tertentu
     */
    public function withDifficulty(string $difficulty): static
    {
        if (!in_array($difficulty, self::AVAILABLE_DIFFICULTIES)) {
            throw new \InvalidArgumentException("Level kesulitan '$difficulty' tidak valid");
        }

        return $this->state(['level_kesulitan' => $difficulty]);
    }

    /**
     * State untuk mata pelajaran dengan kategori tertentu
     */
    public function withCategory(string $category): static
    {
        if (!array_key_exists($category, self::AVAILABLE_CATEGORIES)) {
            throw new \InvalidArgumentException("Kategori '$category' tidak valid");
        }

        $name = $this->faker->randomElement(self::AVAILABLE_CATEGORIES[$category]);
        return $this->state([
            'nama_pelajaran' => $name,
            'kode_pelajaran' => $this->generateKodePelajaran($name),
            'kategori' => $category
        ]);
    }

    /**
     * State untuk mata pelajaran dengan tingkat kelas tertentu
     */
    public function withGrades(array $grades): static
    {
        foreach ($grades as $grade) {
            if (!in_array($grade, self::AVAILABLE_GRADES)) {
                throw new \InvalidArgumentException("Tingkat kelas '$grade' tidak valid");
            }
        }

        return $this->state(['tingkat_kelas' => $grades]);
    }

    /**
     * State untuk mata pelajaran dengan KKM tertentu
     */
    public function withKKM(int $kkm): static
    {
        if ($kkm < 0 || $kkm > 100) {
            throw new \InvalidArgumentException("KKM harus antara 0 dan 100");
        }

        return $this->state(['kkm' => $kkm]);
    }
}
