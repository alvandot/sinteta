<?php

namespace Database\Factories;

use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\Ujian;
use App\Models\DaftarUjianSiswa;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DaftarUjianSiswaFactory extends Factory
{
    protected $model = DaftarUjianSiswa::class;

    /**
     * Status yang tersedia untuk pendaftaran ujian
     */
    private const AVAILABLE_STATUSES = [
        'belum_mulai',     // Belum mulai
        'sedang_mengerjakan', // Sedang mengerjakan
    ];

    public function definition(): array
    {
        return [
            'mata_pelajaran_id' => MataPelajaran::factory(),
            'ujian_id' => Ujian::factory(),
            'siswa_id' => Siswa::factory(),
            'tentor_id' => Tentor::factory(),
            'waktu_mulai_pengerjaan' => null,
            'waktu_selesai_pengerjaan' => null,
            'nilai' => null,
            'status' => 'belum_mulai',
            'catatan' => null,
        ];
    }

    /**
     * Menghasilkan catatan yang valid
     */
    protected function generateNotes(): string
    {
        $notesParts = [
            'Catatan Ujian:',
            '- Waktu pengerjaan: ' . $this->faker->numberBetween(30, 120) . ' menit',
            '- Tingkat kesulitan: ' . $this->faker->randomElement(['Mudah', 'Sedang', 'Sulit']),
            'Feedback:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $notesParts);
    }

    /**
     * State untuk pendaftaran dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => 'belum_mulai']);
    }

    /**
     * State untuk pendaftaran dengan ujian tertentu
     */
    public function forUjian(\App\Models\Akademik\Ujian $ujian): static
    {
        return $this->state(['ujian_id' => $ujian->id]);
    }

    /**
     * State untuk pendaftaran dengan siswa tertentu
     */
    public function forSiswa(Siswa $siswa): static
    {
        if ($siswa->role !== 'siswa') {
            throw new \InvalidArgumentException("User harus memiliki role 'siswa'");
        }

        return $this->state(['siswa_id' => $siswa->id]);
    }

    /**
     * State untuk pendaftaran yang sudah selesai dengan nilai
     */
    public function completed(int $totalScore, int $correctCount, int $wrongCount): static
    {
        if ($totalScore < 0 || $totalScore > 100) {
            throw new \InvalidArgumentException("Nilai total harus antara 0 dan 100");
        }

        if ($correctCount < 0 || $wrongCount < 0) {
            throw new \InvalidArgumentException("Jumlah benar/salah tidak boleh negatif");
        }

        return $this->state([
            'status' => 'selesai',
            'nilai_total' => $totalScore,
            'jumlah_benar' => $correctCount,
            'jumlah_salah' => $wrongCount
        ]);
    }

    /**
     * State untuk pendaftaran dengan waktu mulai dan selesai tertentu
     */
    public function withTimeRange(\DateTime $startTime, \DateTime $endTime): static
    {
        if ($startTime >= $endTime) {
            throw new \InvalidArgumentException("Waktu mulai harus lebih awal dari waktu selesai");
        }

        return $this->state([
            'waktu_mulai' => $startTime,
            'waktu_selesai' => $endTime
        ]);
    }

    /**
     * State untuk pendaftaran dengan catatan tertentu
     */
    public function withNotes(string $notes): static
    {
        return $this->state(['catatan' => $notes]);
    }

    // State untuk ujian yang belum mulai
    public function belumMulai(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'waktu_mulai_pengerjaan' => null,
                'waktu_selesai_pengerjaan' => null,
                'nilai' => null,
                'status' => 'belum_mulai',
            ];
        });
    }

    // State untuk ujian yang sedang dikerjakan
    public function sedangDikerjakan(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'waktu_mulai_pengerjaan' => now(),
                'waktu_selesai_pengerjaan' => null,
                'nilai' => null,
                'status' => 'sedang_mengerjakan',
            ];
        });
    }

    // State untuk ujian yang sudah selesai
    public function selesai(): Factory
    {
        return $this->state(function (array $attributes) {
            $waktu_mulai = now()->subHours(2);
            return [
                'waktu_mulai_pengerjaan' => $waktu_mulai,
                'waktu_selesai_pengerjaan' => now(),
                'nilai' => $this->faker->numberBetween(0, 100),
                'status' => 'selesai',
            ];
        });
    }

    // State untuk ujian dengan catatan
    public function withCatatan(string $catatan = null): Factory
    {
        return $this->state(function (array $attributes) use ($catatan) {
            return [
                'catatan' => $catatan ?? $this->faker->sentence(),
            ];
        });
    }
}
