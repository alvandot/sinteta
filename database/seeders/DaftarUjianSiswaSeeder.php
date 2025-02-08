<?php

namespace Database\Seeders;

use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\Ujian;
use App\Models\DaftarUjianSiswa;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class DaftarUjianSiswaSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('id_ID');
    }

    /**
     * Status yang tersedia untuk daftar ujian
     */
    private const AVAILABLE_STATUSES = [
        'belum_mulai',
        'sedang_mengerjakan',
        'selesai',
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang sudah ada
        $mataPelajarans = MataPelajaran::all();
        $ujians = Ujian::all();
        $siswas = Siswa::all();
        $tentors = Tentor::all();

        // Jika data belum ada, buat data baru
        if ($mataPelajarans->isEmpty()) {
            $mataPelajarans = MataPelajaran::factory(5)->create();
        }
        if ($ujians->isEmpty()) {
            $ujians = Ujian::factory(40)->create();
        }
        if ($siswas->isEmpty()) {
            $siswas = Siswa::factory(50)->create();
        }
        if ($tentors->isEmpty()) {
            $tentors = Tentor::factory(5)->create();
        }

        // Buat array untuk melacak ujian yang sudah didaftarkan untuk setiap siswa
        $registeredExams = [];

        // Buat data ujian untuk setiap siswa
        foreach ($siswas as $siswa) {
            $registeredExams[$siswa->id] = [];

            // Ujian yang belum mulai (2 ujian per siswa)
            $this->createExams($siswa, $ujians, $mataPelajarans, $tentors, 5, 'belum_mulai', $registeredExams);

            // Ujian yang sedang dikerjakan (1 ujian per siswa)
            $this->createExams($siswa, $ujians, $mataPelajarans, $tentors, 1, 'sedang_mengerjakan', $registeredExams);

        }
    }

    /**
     * Membuat ujian untuk siswa dengan status tertentu
     */
    private function createExams($siswa, $ujians, $mataPelajarans, $tentors, $count, $status, &$registeredExams): void
    {
        $availableUjians = $ujians->filter(function ($ujian) use ($registeredExams, $siswa) {
            return !in_array($ujian->id, $registeredExams[$siswa->id]);
        });

        if ($availableUjians->isEmpty()) {
            return;
        }

        for ($i = 0; $i < $count && !$availableUjians->isEmpty(); $i++) {
            $ujian = $availableUjians->random();
            $mataPelajaran = $mataPelajarans->random();
            $tentor = $tentors->random();

            DaftarUjianSiswa::create([
                'siswa_id' => $siswa->id,
                'mata_pelajaran_id' => $mataPelajaran->id,
                'ujian_id' => $ujian->id,
                'tentor_id' => $tentor->id,
                'waktu_mulai_pengerjaan' => $status === 'sedang_mengerjakan' ? now() : null,
                'waktu_selesai_pengerjaan' => $status === 'selesai' ? now() : null,
                'nilai' => $status === 'selesai' ? rand(0, 100) : null,
                'status' => $status,
                'catatan' => null,
            ]);

            // Catat ujian yang sudah didaftarkan
            $registeredExams[$siswa->id][] = $ujian->id;
            $availableUjians = $availableUjians->filter(function ($u) use ($ujian) {
                return $u->id !== $ujian->id;
            });
        }
    }

    /**
     * Mendaftarkan siswa ke ujian
     */
    private function registerStudentsForExam(Ujian $ujian, $siswas): void
    {
        $this->command->info("Mendaftarkan siswa untuk ujian {$ujian->nama}...");

        // Filter siswa yang kelasnya sesuai dengan ujian
        $eligibleSiswas = $siswas->where('kelas_bimbel_id', $ujian->kelas_bimbel_id);

        foreach ($eligibleSiswas as $siswa) {
            // Buat daftar ujian
            $daftarUjian = DaftarUjianSiswa::create([
                'ujian_id' => $ujian->id,
                'siswa_id' => $siswa->id,
                'waktu_mulai' => $ujian->waktu_mulai,
                'waktu_selesai' => $ujian->waktu_selesai,
                'status' => 'belum_mulai',
                'nilai' => $this->generateScore(),
                'catatan' => $this->generateNotes(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Siswa {$siswa->nama} berhasil didaftarkan ke ujian {$ujian->nama}.");
        }
    }

    /**
     * Menghasilkan waktu selesai berdasarkan waktu mulai dan durasi
     */
    private function generateEndTime(string $startTime, int $duration): string
    {
        return date('Y-m-d H:i:s', strtotime($startTime . " +{$duration} minutes"));
    }

    /**
     * Menghasilkan nilai ujian
     */
    private function generateScore(): ?float
    {
        // 20% chance untuk belum ada nilai
        if ($this->faker->boolean(20)) {
            return null;
        }

        // Generate nilai antara 0-100 dengan 2 desimal
        return round($this->faker->randomFloat(2, 0, 100), 2);
    }

    /**
     * Menghasilkan catatan ujian
     */
    private function generateNotes(): ?string
    {
        // 30% chance untuk ada catatan
        if ($this->faker->boolean(30)) {
            return $this->faker->sentence();
        }

        return null;
    }
}
