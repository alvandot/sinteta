<?php

namespace Database\Factories\Akademik;

use App\Models\Akademik\KelasBimbel;
use App\Models\Cabang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Akademik\KelasBimbel>
 */
class KelasBimbelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KelasBimbel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil cabang yang sudah ada atau buat baru jika tidak ada
        $cabang = Cabang::inRandomOrder()->first()
            ?? Cabang::factory()->create();

        return [
            'nama_kelas' => $this->faker->randomElement([
                'Kelas Reguler A',
                'Kelas Reguler B',
                'Kelas Intensif A',
                'Kelas Intensif B',
                'Kelas Premium A',
                'Kelas Premium B'
            ]),
            'cabang_id' => $cabang->id,
            'deskripsi' => $this->faker->paragraph()
        ];
    }
}
