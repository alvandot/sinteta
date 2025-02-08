<?php

namespace Database\Factories\Soal;

use App\Models\Soal\Soal;
use App\Models\Soal\SoalOpsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalOpsiFactory extends Factory
{
    protected $model = SoalOpsi::class;

    public function definition(): array
    {
        return [
            'soal_id' => Soal::factory(),
            'label' => 'A',
            'teks' => $this->faker->sentence(),
            'is_jawaban' => false,
            'urutan' => 1
        ];
    }

    public function withLabel(string $label): static
    {
        return $this->state(['label' => $label]);
    }

    public function withOrder(int $order): static
    {
        return $this->state(['urutan' => $order]);
    }

    public function forSoal(Soal $soal): static
    {
        return $this->state(['soal_id' => $soal->id]);
    }
} 