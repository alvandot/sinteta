<?php

namespace Database\Factories\Soal;

use App\Models\Soal\Soal;
use App\Models\Soal\PaketSoal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalFactory extends Factory
{
    protected $model = Soal::class;

    public function definition()
    {
        return [
            'paket_soal_id' => PaketSoal::factory(),
            'nomor_urut'    => $this->faker->numberBetween(1, 100),
            'pertanyaan'    => $this->faker->paragraph,
            'jenis_soal'    => $this->faker->randomElement([Soal::JENIS_PILIHAN_GANDA, Soal::JENIS_ESSAY]),
            'kunci_pg'      => $this->faker->randomElement(['a', 'b', 'c', 'd']),
            'kunci_essay'   => $this->faker->paragraph,
            'bobot'         => $this->faker->randomFloat(2, 1, 10),
            'metadata'      => [
                'waktu' => $this->faker->numberBetween(1, 10),
                'level' => $this->faker->randomElement(['mudah', 'sedang', 'sulit']),
            ],
            'created_by'    => User::factory(),
            'updated_by'    => User::factory(),
        ];
    }
} 