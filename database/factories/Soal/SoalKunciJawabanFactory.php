<?php

namespace Database\Factories\Soal;

use App\Models\Soal\Soal;
use App\Models\Soal\SoalKunciJawaban;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalKunciJawabanFactory extends Factory
{
    protected $model = SoalKunciJawaban::class;

    public function definition(): array
    {
        return [
            'soal_id' => Soal::factory(),
            'label' => 'A',
        ];
    }

    public function withLabel(string $label): static
    {
        return $this->state(['label' => $label]);
    }

    public function forSoal(Soal $soal): static
    {
        return $this->state(['soal_id' => $soal->id]);
    }
} 