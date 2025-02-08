<?php

namespace Database\Factories\Users;

use App\Models\Users\Siswa;
use App\Models\KelasBimbel;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    /**
     * Status yang tersedia untuk siswa
     */
    private const AVAILABLE_STATUSES = [
        'active',       // Aktif
        'inactive',     // Tidak Aktif
        'graduated',    // Lulus
        'suspended'     // Ditangguhkan
    ];

    /**
     * Tingkat kelas yang tersedia
     */
    private const AVAILABLE_GRADES = ['X', 'XI', 'XII'];

    /**
     * Jurusan yang tersedia
     */
    private const AVAILABLE_MAJORS = [
        'IPA',      // Ilmu Pengetahuan Alam
        'IPS',      // Ilmu Pengetahuan Sosial
        'BAHASA'    // Bahasa
    ];

    /**
     * Asal sekolah yang tersedia
     */
    private const AVAILABLE_SCHOOLS = [
        'SMAN 1',
        'SMAN 2',
        'SMAN 3',
        'SMAN 4',
        'SMAN 5',
        'SMA Muhammadiyah 1',
        'SMA Muhammadiyah 2',
        'SMA Katolik 1',
        'SMA Kristen 1',
        'MAN 1',
        'MAN 2'
    ];

    public function definition(): array
    {
        $grade = $this->faker->randomElement(self::AVAILABLE_GRADES);
        $major = $this->faker->randomElement(self::AVAILABLE_MAJORS);
        $school = $this->faker->randomElement(self::AVAILABLE_SCHOOLS);

        return [
            'nis' => $this->generateNIS(),
            'nama_lengkap' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->generatePhoneNumber(),
            'alamat' => $this->faker->address(),
            'tingkat_kelas' => $grade,
            'jurusan' => $major,
            'asal_sekolah' => $school,
            'info_ortu' => $this->generateParentInfo(),
            'prestasi' => $this->generateAchievements(),
            'catatan' => $this->generateNotes(),
            'kelas_bimbel_id' => \App\Models\Akademik\KelasBimbel::factory(),
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Menghasilkan NIS yang valid
     */
    protected function generateNIS(): string
    {
        return 'S' . $this->faker->unique()->numerify('########');
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
     * Menghasilkan informasi orang tua yang valid
     */
    protected function generateParentInfo(): string
    {
        $parentInfoParts = [
            'Data Ayah:',
            'Nama: ' . $this->faker->name('male'),
            'Pekerjaan: ' . $this->faker->jobTitle(),
            'No. HP: ' . $this->generatePhoneNumber(),
            '',
            'Data Ibu:',
            'Nama: ' . $this->faker->name('female'),
            'Pekerjaan: ' . $this->faker->jobTitle(),
            'No. HP: ' . $this->generatePhoneNumber()
        ];

        return implode("\n", $parentInfoParts);
    }

    /**
     * Menghasilkan prestasi yang valid
     */
    protected function generateAchievements(): ?string
    {
        $achievementParts = [
            'Prestasi Akademik:',
            '1. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '2. ' . $this->faker->sentence() . ' (' . $this->faker->year() . ')',
            '',
            'Prestasi Non-Akademik:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $achievementParts);
    }

    /**
     * Menghasilkan catatan yang valid
     */
    protected function generateNotes(): ?string
    {
        $notesParts = [
            'Catatan Perkembangan:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence(),
            '',
            'Target Pembelajaran:',
            '1. ' . $this->faker->sentence(),
            '2. ' . $this->faker->sentence()
        ];

        return implode("\n", $notesParts);
    }

    /**
     * State untuk siswa dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk siswa dengan tingkat kelas tertentu
     */
    public function withGrade(string $grade): static
    {
        if (!in_array($grade, self::AVAILABLE_GRADES)) {
            throw new \InvalidArgumentException("Tingkat kelas '$grade' tidak valid");
        }

        return $this->state(['tingkat_kelas' => $grade]);
    }

    /**
     * State untuk siswa dengan jurusan tertentu
     */
    public function withMajor(string $major): static
    {
        if (!in_array($major, self::AVAILABLE_MAJORS)) {
            throw new \InvalidArgumentException("Jurusan '$major' tidak valid");
        }

        return $this->state(['jurusan' => $major]);
    }

    /**
     * State untuk siswa dengan asal sekolah tertentu
     */
    public function fromSchool(string $school): static
    {
        if (!in_array($school, self::AVAILABLE_SCHOOLS)) {
            throw new \InvalidArgumentException("Asal sekolah '$school' tidak valid");
        }

        return $this->state(['asal_sekolah' => $school]);
    }

    /**
     * State untuk siswa dengan kelas bimbel tertentu
     */
    public function forKelasBimbel(\App\Models\Akademik\KelasBimbel $kelasBimbel): static
    {
        return $this->state(['kelas_bimbel_id' => $kelasBimbel->id]);
    }

    /**
     * State untuk siswa dengan informasi orang tua tertentu
     */
    public function withParentInfo(string $parentInfo): static
    {
        return $this->state(['info_ortu' => $parentInfo]);
    }

    /**
     * State untuk siswa dengan prestasi tertentu
     */
    public function withAchievements(string $achievements): static
    {
        return $this->state(['prestasi' => $achievements]);
    }

    /**
     * State untuk siswa dengan catatan tertentu
     */
    public function withNotes(string $notes): static
    {
        return $this->state(['catatan' => $notes]);
    }
}
