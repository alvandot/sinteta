<?php

namespace Database\Factories\Users;

use App\Models\Users\Tentor;
use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class TentorFactory extends Factory
{
    protected $model = Tentor::class;

    /**
     * Status yang tersedia untuk tentor
     */
    private const AVAILABLE_STATUSES = [
        'active',       // Aktif
        'inactive',     // Tidak Aktif
        'suspended',    // Ditangguhkan
        'resigned'      // Mengundurkan Diri
    ];

    /**
     * Pendidikan terakhir yang tersedia
     */
    private const AVAILABLE_EDUCATIONS = [
        'S1',      // Sarjana
        'S2',      // Magister
        'S3'       // Doktor
    ];

    /**
     * Bidang studi yang tersedia
     */
    private const AVAILABLE_MAJORS = [
        'Pendidikan Matematika',
        'Pendidikan Fisika',
        'Pendidikan Kimia',
        'Pendidikan Biologi',
        'Pendidikan Bahasa Indonesia',
        'Pendidikan Bahasa Inggris',
        'Pendidikan Sejarah',
        'Pendidikan Geografi',
        'Pendidikan Ekonomi'
    ];

    public function definition(): array
    {
        $education = $this->faker->randomElement(self::AVAILABLE_EDUCATIONS);
        $major = $this->faker->randomElement(self::AVAILABLE_MAJORS);

        return [
            'user_id' => \App\Models\User::factory(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->generatePhoneNumber(),
            'pendidikan_terakhir' => $education,
            'jurusan' => $major,
            'spesialisasi' => $this->faker->randomElement(self::AVAILABLE_MAJORS),
            'foto' => null,
            'status' => 'aktif',
            'tanggal_bergabung' => now(),
            'tanggal_berakhir' => null,
            'catatan' => $this->faker->paragraph(),
            'gaji_pokok' => $this->faker->numberBetween(3000000, 5000000),
            'tunjangan' => $this->faker->numberBetween(500000, 1000000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan NIP yang valid
     */
    protected function generateNIP(): string
    {
        return 'T' . $this->faker->unique()->numerify('########');
    }

    /**
     * Menghasilkan nomor HP yang valid
     */
    protected function generatePhoneNumber(): string
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0852', '0853', '0811', '0814'];
        return $this->faker->randomElement($prefixes) . $this->faker->numerify('########');
    }

    /**
     * Menghasilkan pengalaman mengajar yang valid
     */
    protected function generateTeachingExperience(): string
    {
        $experienceParts = [
            'Pengalaman Mengajar:',
            '1. ' . $this->faker->company() . ' (' . $this->faker->year() . ' - ' . $this->faker->year() . ')',
            '2. ' . $this->faker->company() . ' (' . $this->faker->year() . ' - ' . $this->faker->year() . ')',
            '',
            'Keahlian:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $experienceParts);
    }

    /**
     * Menghasilkan sertifikasi yang valid
     */
    protected function generateCertifications(): ?string
    {
        $certificationParts = [
            'Sertifikasi:',
            '1. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '2. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '',
            'Pelatihan:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $certificationParts);
    }

    /**
     * Menghasilkan prestasi yang valid
     */
    protected function generateAchievements(): ?string
    {
        $achievementParts = [
            'Prestasi:',
            '1. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '2. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '',
            'Penghargaan:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $achievementParts);
    }

    /**
     * State untuk tentor dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk tentor dengan pendidikan tertentu
     */
    public function withEducation(string $education): static
    {
        if (!in_array($education, self::AVAILABLE_EDUCATIONS)) {
            throw new \InvalidArgumentException("Pendidikan '$education' tidak valid");
        }

        return $this->state(['pendidikan_terakhir' => $education]);
    }

    /**
     * State untuk tentor dengan bidang studi tertentu
     */
    public function withMajor(string $major): static
    {
        if (!in_array($major, self::AVAILABLE_MAJORS)) {
            throw new \InvalidArgumentException("Bidang studi '$major' tidak valid");
        }

        return $this->state(['bidang_studi' => $major]);
    }

    /**
     * State untuk tentor dengan mata pelajaran tertentu
     */
    public function forMataPelajaran(\App\Models\Akademik\MataPelajaran $mataPelajaran): static
    {
        return $this->state(['mata_pelajaran_id' => $mataPelajaran->id]);
    }

    /**
     * State untuk tentor dengan pengalaman mengajar tertentu
     */
    public function withTeachingExperience(string $experience): static
    {
        return $this->state(['pengalaman_mengajar' => $experience]);
    }

    /**
     * State untuk tentor dengan sertifikasi tertentu
     */
    public function withCertifications(string $certifications): static
    {
        return $this->state(['sertifikasi' => $certifications]);
    }

    /**
     * State untuk tentor dengan prestasi tertentu
     */
    public function withAchievements(string $achievements): static
    {
        return $this->state(['prestasi' => $achievements]);
    }
}
