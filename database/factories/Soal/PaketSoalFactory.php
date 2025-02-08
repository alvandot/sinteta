<?php

namespace Database\Factories\Soal;

use App\Models\Soal\PaketSoal;
use App\Models\Akademik\MataPelajaran;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaketSoalFactory extends Factory
{
    protected $model = PaketSoal::class;

    /**
     * Status yang tersedia untuk paket soal
     */
    private const AVAILABLE_STATUSES = ['draft', 'published', 'archived'];

    /**
     * Tingkat kesulitan yang tersedia
     */
    private const AVAILABLE_DIFFICULTIES = ['mudah', 'sedang', 'sulit'];

    /**
     * Tipe paket soal yang tersedia
     */
    private const AVAILABLE_TYPES = ['latihan', 'ujian', 'remedial'];

    public function definition(): array
    {
        return [
            'nama' => $this->generateTitle(),
            'deskripsi' => $this->generateDescription(),
            'mata_pelajaran_id' => MataPelajaran::factory(),
            'tingkat' => $this->faker->randomElement(['X', 'XI', 'XII']),
            'tahun' => now()->year,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan judul yang valid
     */
    protected function generateTitle(): string
    {
        $topics = [
            'Ulangan Harian',
            'Ujian Tengah Semester',
            'Ujian Akhir Semester',
            'Latihan Soal',
            'Remedial'
        ];

        $subjects = [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'Bahasa Indonesia',
            'Bahasa Inggris'
        ];

        $chapters = [
            'Bab 1',
            'Bab 2',
            'Bab 3',
            'Semester 1',
            'Semester 2'
        ];

        return $this->faker->randomElement($topics) . ' ' .
               $this->faker->randomElement($subjects) . ' ' .
               $this->faker->randomElement($chapters);
    }

    /**
     * Menghasilkan deskripsi yang valid
     */
    protected function generateDescription(): string
    {
        $descriptionParts = [
            'Paket soal ini mencakup materi:',
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
     * Menghasilkan instruksi yang valid
     */
    protected function generateInstructions(): string
    {
        $instructionParts = [
            'Petunjuk Pengerjaan:',
            '1. Baca soal dengan teliti',
            '2. Waktu pengerjaan ' . $this->faker->numberBetween(30, 120) . ' menit',
            '3. Kerjakan soal dari yang termudah',
            '4. Periksa kembali jawaban sebelum submit',
            'Catatan:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $instructionParts);
    }

    /**
     * State untuk paket soal dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk paket soal dengan level kesulitan tertentu
     */
    public function withDifficulty(string $difficulty): static
    {
        if (!in_array($difficulty, self::AVAILABLE_DIFFICULTIES)) {
            throw new \InvalidArgumentException("Level kesulitan '$difficulty' tidak valid");
        }

        return $this->state(['level_kesulitan' => $difficulty]);
    }

    /**
     * State untuk paket soal dengan tipe tertentu
     */
    public function withType(string $type): static
    {
        if (!in_array($type, self::AVAILABLE_TYPES)) {
            throw new \InvalidArgumentException("Tipe '$type' tidak valid");
        }

        return $this->state(['tipe' => $type]);
    }

    /**
     * State untuk paket soal dengan mata pelajaran tertentu
     */
    public function forMataPelajaran(MataPelajaran $mataPelajaran): static
    {
        return $this->state(['mata_pelajaran_id' => $mataPelajaran->id]);
    }

    /**
     * State untuk paket soal dengan tentor tertentu
     */
    public function forTentor(Tentor $tentor): static
    {
        return $this->state(['tentor_id' => $tentor->id]);
    }

    /**
     * State untuk paket soal dengan durasi tertentu
     */
    public function withDuration(int $minutes): static
    {
        if ($minutes < 15 || $minutes > 180) {
            throw new \InvalidArgumentException("Durasi harus antara 15 dan 180 menit");
        }

        return $this->state(['durasi' => $minutes]);
    }

    /**
     * State untuk paket soal dengan jumlah soal tertentu
     */
    public function withQuestionCount(int $count): static
    {
        if ($count < 5 || $count > 100) {
            throw new \InvalidArgumentException("Jumlah soal harus antara 5 dan 100");
        }

        return $this->state(['jumlah_soal' => $count]);
    }

    /**
     * State untuk paket soal dengan KKM tertentu
     */
    public function withKKM(int $kkm): static
    {
        if ($kkm < 0 || $kkm > 100) {
            throw new \InvalidArgumentException("KKM harus antara 0 dan 100");
        }

        return $this->state(['kkm' => $kkm]);
    }
}
