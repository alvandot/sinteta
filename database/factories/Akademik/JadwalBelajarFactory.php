<?php

namespace Database\Factories\Akademik;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\MataPelajaran;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalBelajarFactory extends Factory
{
    protected $model = JadwalBelajar::class;

    /**
     * Status yang tersedia untuk jadwal belajar
     */
    private const AVAILABLE_STATUSES = ['aktif', 'selesai', 'dibatalkan'];

    /**
     * Hari yang tersedia
     */
    private const AVAILABLE_DAYS = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    ];

    /**
     * Ruangan yang tersedia
     */
    private const AVAILABLE_ROOMS = [
        'Ruang 1A',
        'Ruang 1B',
        'Ruang 2A',
        'Ruang 2B',
        'Ruang 3A',
        'Ruang 3B',
        'Lab Komputer',
        'Lab Bahasa'
    ];

    public function definition(): array
    {
        $startTime = $this->faker->dateTimeBetween('08:00', '17:00');
        $endTime = clone $startTime;
        $endTime->modify('+90 minutes');

        // Generate tanggal mulai antara 1 bulan sebelumnya dan 1 bulan setelahnya
        $tanggalMulai = $this->faker->dateTimeBetween('-1 month', '+1 month');

        // Set status berdasarkan tanggal mulai
        $status = $tanggalMulai < now() ? 'selesai' : 'aktif';

        // Membuat kelas bimbel terlebih dahulu
        $kelasBimbel = KelasBimbel::factory()->create();

        return [
            'nama_jadwal' => 'Jadwal ' . $this->faker->word(),
            'tanggal_mulai' => $tanggalMulai,
            'mata_pelajaran_id' => MataPelajaran::factory(),
            'hari' => $this->faker->randomElement(self::AVAILABLE_DAYS),
            'jam_mulai' => $startTime->format('H:i'),
            'jam_selesai' => $endTime->format('H:i'),
            'ruangan' => $this->faker->randomElement(self::AVAILABLE_ROOMS),
            'kelas_id' => $kelasBimbel->id,
            'tentor_id' => Tentor::factory(),
            'kapasitas' => $this->faker->numberBetween(10, 30),
            'jumlah_siswa' => 0,
            'status' => $status,
            'catatan' => $this->generateDescription(),
            'kelas_bimbel_id' => $kelasBimbel->id,
        ];
    }

    /**
     * Menghasilkan deskripsi yang valid
     */
    protected function generateDescription(): string
    {
        $descriptionParts = [
            'Jadwal belajar reguler dengan:',
            '- Materi: ' . $this->faker->sentence(),
            '- Target: ' . $this->faker->sentence(),
            'Catatan:',
            '- ' . $this->faker->sentence(),
            '- ' . $this->faker->sentence()
        ];

        return implode("\n", $descriptionParts);
    }

    /**
     * State untuk jadwal dengan status tertentu
     */
    public function withStatus(string $status): static
    {
        if (!in_array($status, self::AVAILABLE_STATUSES)) {
            throw new \InvalidArgumentException("Status '$status' tidak valid");
        }

        return $this->state(['status' => $status]);
    }

    /**
     * State untuk jadwal dengan hari tertentu
     */
    public function onDay(string $day): static
    {
        if (!in_array($day, self::AVAILABLE_DAYS)) {
            throw new \InvalidArgumentException("Hari '$day' tidak valid");
        }

        return $this->state(['hari' => $day]);
    }

    /**
     * State untuk jadwal dengan ruangan tertentu
     */
    public function inRoom(string $room): static
    {
        if (!in_array($room, self::AVAILABLE_ROOMS)) {
            throw new \InvalidArgumentException("Ruangan '$room' tidak valid");
        }

        return $this->state(['ruangan' => $room]);
    }

    /**
     * State untuk jadwal dengan kelas tertentu
     */
    public function forKelas(KelasBimbel $kelas): static
    {
        return $this->state([
            'kelas_id' => $kelas->id,
            'kelas_bimbel_id' => $kelas->id
        ]);
    }

    /**
     * State untuk jadwal dengan mata pelajaran tertentu
     */
    public function forMataPelajaran(MataPelajaran $mataPelajaran): static
    {
        return $this->state(['mata_pelajaran_id' => $mataPelajaran->id]);
    }

    /**
     * State untuk jadwal dengan tentor tertentu
     */
    public function forTentor(Tentor $tentor): static
    {
        return $this->state(['tentor_id' => $tentor->id]);
    }

    /**
     * State untuk jadwal dengan waktu tertentu
     */
    public function withTimeRange(string $startTime, string $endTime): static
    {
        $start = \DateTime::createFromFormat('H:i', $startTime);
        $end = \DateTime::createFromFormat('H:i', $endTime);

        if (!$start || !$end) {
            throw new \InvalidArgumentException("Format waktu tidak valid (H:i)");
        }

        if ($start >= $end) {
            throw new \InvalidArgumentException("Jam mulai harus lebih awal dari jam selesai");
        }

        return $this->state([
            'jam_mulai' => $startTime,
            'jam_selesai' => $endTime
        ]);
    }

    /**
     * State untuk jadwal dengan kapasitas tertentu
     */
    public function withCapacity(int $capacity): static
    {
        if ($capacity < 1 || $capacity > 50) {
            throw new \InvalidArgumentException("Kapasitas harus antara 1 dan 50");
        }

        return $this->state(['kapasitas' => $capacity]);
    }

    /**
     * State untuk jadwal dengan keterangan tertentu
     */
    public function withDescription(string $description): static
    {
        return $this->state(['catatan' => $description]);
    }
}
