<?php

namespace Database\Factories\Pivot;

use App\Models\Akademik\MataPelajaran;
use App\Models\Pivot\MataPelajaranTentor;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivot\MataPelajaranTentor>
 */
class MataPelajaranTentorFactory extends Factory
{
    /**
     * The model class associated with the factory.
     *
     * @var string
     */
    protected $model = MataPelajaranTentor::class;

    /**
     * Status yang tersedia untuk mata pelajaran tentor
     */
    private const STATUS = [
        'AKTIF' => 'aktif',
        'NONAKTIF' => 'nonaktif'
    ];

    /**
     * Define the model's default state.
     *
     * Generates a random association between:
     * - Tentor (teacher)
     * - Mata Pelajaran (subject)
     * With status and optional notes
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tentor_id' => Tentor::factory(),
            'mata_pelajaran_id' => MataPelajaran::factory(),
            'status' => $this->faker->randomElement(array_values(self::STATUS)),
            'catatan' => $this->faker->optional()->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Set specific tentor for the mata pelajaran.
     *
     * @param int|Tentor $tentor
     * @return static
     */
    public function forTentor(int|Tentor $tentor): static
    {
        $tentorId = $tentor instanceof Tentor ? $tentor->id : $tentor;

        return $this->state(fn (array $attributes) => [
            'tentor_id' => $tentorId,
        ]);
    }

    /**
     * Set specific mata pelajaran.
     *
     * @param int|MataPelajaran $mataPelajaran
     * @return static
     */
    public function forMataPelajaran(int|MataPelajaran $mataPelajaran): static
    {
        $mapelId = $mataPelajaran instanceof MataPelajaran ? $mataPelajaran->id : $mataPelajaran;

        return $this->state(fn (array $attributes) => [
            'mata_pelajaran_id' => $mapelId,
        ]);
    }

    /**
     * Set status as aktif.
     *
     * @return static
     */
    public function aktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => self::STATUS['AKTIF'],
        ]);
    }

    /**
     * Set status as nonaktif.
     *
     * @return static
     */
    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => self::STATUS['NONAKTIF'],
        ]);
    }

    /**
     * Set catatan for the mata pelajaran tentor.
     *
     * @param string $catatan
     * @return static
     */
    public function withCatatan(string $catatan): static
    {
        return $this->state(fn (array $attributes) => [
            'catatan' => $catatan,
        ]);
    }
}
