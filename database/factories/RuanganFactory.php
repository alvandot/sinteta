<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ruangan>
 */
class RuanganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['aktif', 'nonaktif', 'maintenance'];

        return [
            'cabang_id' => \App\Models\Cabang::factory(),
            'nama' => 'Ruangan ' . $this->faker->unique()->numberBetween(1, 100),
            'kode' => 'R' . $this->faker->unique()->numberBetween(100, 999),
            'kapasitas' => $this->faker->numberBetween(10, 40),
            'deskripsi' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement($status),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
