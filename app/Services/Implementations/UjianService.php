<?php

namespace App\Services\Implementations;

use App\Services\Contracts\UjianServiceInterface;
use App\Models\UjianSiswa;
use App\Models\Jawaban;
use App\Models\HasilUjian;
use App\Models\DaftarUjianSiswa;
use App\Models\Soal\Soal;
use App\Models\Soal\PaketSoal;
use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\Ujian;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class UjianService implements UjianServiceInterface
{
    protected $ujianSiswa;
    protected $jawaban;
    protected $hasilUjian;
    protected $daftarUjianSiswa;
    protected $soal;
    protected $paketSoal;
    protected $mataPelajaran;
    protected $kelasBimbel;

    public function __construct(
        DaftarUjianSiswa $ujianSiswa,
        Jawaban $jawaban,
        HasilUjian $hasilUjian,
        DaftarUjianSiswa $daftarUjianSiswa,
        Soal $soal,
        PaketSoal $paketSoal,
        MataPelajaran $mataPelajaran,
        KelasBimbel $kelasBimbel
    ) {
        $this->ujianSiswa = $ujianSiswa;
        $this->jawaban = $jawaban;
        $this->hasilUjian = $hasilUjian;
        $this->daftarUjianSiswa = $daftarUjianSiswa;
        $this->soal = $soal;
        $this->paketSoal = $paketSoal;
        $this->mataPelajaran = $mataPelajaran;
        $this->kelasBimbel = $kelasBimbel;
    }

    /**
     * Get all UjianSiswa records
     *
     * @return Collection
     */
    public function getUjianSiswa(): Collection
    {
        return $this->ujianSiswa->with(['siswa', 'ujian', 'mataPelajaran'])->get();
    }

    /**
     * Get all Jawaban records
     *
     * @return Collection
     */
    public function getJawaban(): Collection
    {
        return $this->jawaban->with(['ujianSiswa', 'soals'])->get();
    }

    /**
     * Get all HasilUjian records
     *
     * @return Collection
     */
    public function getHasilUjian(): Collection
    {
        return $this->hasilUjian->with(['ujianSiswa'])->get();
    }

    /**
     * Get all DaftarUjianSiswa records
     *
     * @return Collection
     */
    public function getDaftarUjianSiswa(): Collection
    {
        return $this->daftarUjianSiswa->with(['siswa', 'ujian'])->get();
    }

    /**
     * Get all Soal records
     *
     * @return Collection
     */
    public function getSoal(): Collection
    {
        return $this->soal->with(['paketSoal'])->get();
    }

    /**
     * Get all PaketSoal records
     *
     * @return Collection
     */
    public function getPaketSoal(): Collection
    {
        return $this->paketSoal->with(['soals'])->get();
    }

    /**
     * Create a new UjianSiswa record
     *
     * @param array $data
     * @return UjianSiswa
     * @throws ValidationException
     */
    public function createUjianSiswa(array $data): UjianSiswa
    {
        $validator = Validator::make($data, [
            'siswa_id' => 'required|exists:siswa,id',
            'ujian_id' => 'required|exists:ujian,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'status' => 'required|in:belum_mulai,sedang_berlangsung,selesai'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                $ujianSiswa = $this->ujianSiswa->create($data);

                // Create DaftarUjianSiswa record
                $this->daftarUjianSiswa->create([
                    'siswa_id' => $data['siswa_id'],
                    'ujian_id' => $data['ujian_id'],
                    'status' => 'terdaftar'
                ]);

                return $ujianSiswa;
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat ujian siswa: ' . $e->getMessage());
        }
    }

    /**
     * Submit jawaban for UjianSiswa
     *
     * @param array $data
     * @return Jawaban
     * @throws ValidationException
     */
    public function submitJawaban(array $data): Jawaban
    {
        $validator = Validator::make($data, [
            'ujian_siswa_id' => 'required|exists:ujian_siswa,id',
            'soal_id' => 'required|exists:soal,id',
            'jawaban' => 'required|string',
            'is_correct' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                $jawaban = $this->jawaban->create($data);

                // Update UjianSiswa status if needed
                $ujianSiswa = $this->ujianSiswa->find($data['ujian_siswa_id']);
                if ($ujianSiswa->status === 'belum_mulai') {
                    $ujianSiswa->update(['status' => 'sedang_berlangsung']);
                }

                return $jawaban;
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal menyimpan jawaban: ' . $e->getMessage());
        }
    }

    /**
     * Calculate and create HasilUjian for UjianSiswa
     *
     * @param int $ujianSiswaId
     * @return HasilUjian
     * @throws \Exception
     */
    public function calculateHasilUjian(int $ujianSiswaId): HasilUjian
    {
        try {
            return DB::transaction(function () use ($ujianSiswaId) {
                $ujianSiswa = $this->ujianSiswa->findOrFail($ujianSiswaId);
                $jawaban = $this->jawaban->where('ujian_siswa_id', $ujianSiswaId)->get();

                $totalSoal = $jawaban->count();
                $jawabanBenar = $jawaban->where('is_correct', true)->count();
                $nilai = ($jawabanBenar / $totalSoal) * 100;

                // Update UjianSiswa status
                $ujianSiswa->update(['status' => 'selesai']);

                return $this->hasilUjian->create([
                    'ujian_siswa_id' => $ujianSiswaId,
                    'nilai' => $nilai,
                    'jumlah_benar' => $jawabanBenar,
                    'jumlah_salah' => $totalSoal - $jawabanBenar,
                    'total_soal' => $totalSoal
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghitung hasil ujian: ' . $e->getMessage());
        }
    }

    /**
     * Get UjianSiswa by ID with relations
     *
     * @param int $id
     * @return UjianSiswa|null
     */
    public function getUjianSiswaById(int $id): ?UjianSiswa
    {
        return $this->ujianSiswa->with(['siswa', 'ujian', 'jawaban', 'hasilUjian'])->find($id);
    }

    /**
     * Get PaketSoal by ID with relations
     *
     * @param int $id
     * @return PaketSoal|null
     */
    public function getPaketSoalById(int $id): ?PaketSoal
    {
        return $this->paketSoal->with(['soal'])->find($id);
    }

    /**
     * Update UjianSiswa status
     *
     * @param int $id
     * @param string $status
     * @return bool
     * @throws ValidationException
     */
    public function updateUjianSiswaStatus(int $id, string $status): bool
    {
        $validator = Validator::make(['status' => $status], [
            'status' => 'required|in:belum_mulai,sedang_berlangsung,selesai'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            $ujianSiswa = $this->ujianSiswa->findOrFail($id);
            return $ujianSiswa->update(['status' => $status]);
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupdate status ujian: ' . $e->getMessage());
        }
    }

    /**
     * Get all Daftar Ujian records
     *
     * @return Collection
     */
    public function getDaftarUjian(): Collection
    {
        return $this->daftarUjianSiswa->with(['siswa', 'ujian'])->get();
    }

    /**
     * Get mata pelajaran options for dropdown
     *
     * @return array
     */
    public function getMataPelajaranOptions(): array
    {
        return $this->mataPelajaran->select('id', DB::raw("nama_pelajaran as name"))->get()->toArray();
    }

    /**
     * Get kelas options for dropdown
     *
     * @return array
     */
    public function getKelasOptions(): array
    {
        return $this->kelasBimbel->select('id', DB::raw("nama_kelas as name"))->get()->toArray();
    }

    /**
     * Create a new Ujian record
     *
     * @param array $data
     * @return Ujian
     * @throws ValidationException
     */
    public function createUjian(array $data): Ujian
    {
        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'kkm' => 'required|integer|min:0|max:100',
            'paket_soal_id' => 'required|exists:paket_soals,id',
            'mode_pengacakan' => 'required|string|in:soal,soal_dan_jawaban,tidak_acak',
            'tampilkan_hasil' => 'boolean',
            'tampilkan_pembahasan' => 'boolean',
            'dapat_mengulang' => 'boolean',
            'aktif' => 'boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                // Validasi paket soal
                $paketSoal = $this->paketSoal->findOrFail($data['paket_soal_id']);

                if ($paketSoal->mata_pelajaran_id != $data['mata_pelajaran_id']) {
                    throw new \Exception('Paket soal tidak sesuai dengan mata pelajaran yang dipilih');
                }

                // Buat ujian baru
                return Ujian::create([
                    'nama' => $data['nama'],
                    'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                    'kelas_id' => $data['kelas_id'],
                    'waktu_mulai' => $data['waktu_mulai'],
                    'waktu_selesai' => $data['waktu_selesai'],
                    'durasi' => $data['durasi'],
                    'kkm' => $data['kkm'],
                    'paket_soal_id' => $data['paket_soal_id'],
                    'mode_pengacakan' => $data['mode_pengacakan'],
                    'tampilkan_hasil' => $data['tampilkan_hasil'] ?? false,
                    'tampilkan_pembahasan' => $data['tampilkan_pembahasan'] ?? false,
                    'dapat_mengulang' => $data['dapat_mengulang'] ?? false,
                    'aktif' => $data['aktif'] ?? false
                ]);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat ujian: ' . $e->getMessage());
        }
    }

    public function hitungNilai($soals, array $jawaban): float
    {
        try {
            $total_bobot = 0;
            $nilai = 0;

            foreach ($soals as $index => $soal) {
                $bobot = $soal->bobot ?? 1;
                $total_bobot += $bobot;

                if (!isset($jawaban[$index])) {
                    continue;
                }

                $nilai += $this->hitungNilaiSoal($soal, $jawaban[$index], $bobot);
            }

            return $total_bobot > 0 ? round(($nilai / $total_bobot) * 100, 2) : 0;
        } catch (\Exception $e) {
            Log::error('Error dalam perhitungan nilai di service', [
                'error' => $e->getMessage(),
                'soals' => $soals,
                'jawaban' => $jawaban
            ]);
            throw $e;
        }
    }

    private function hitungNilaiSoal($soal, $jawaban, float $bobot): float
    {
        switch ($soal->jenis_soal) {
            case 'pilihan_ganda':
            case 'pg':
                return $this->hitungNilaiPG($soal, $jawaban, $bobot);
            case 'multiple_choice':
            case 'mc':
                return $this->hitungNilaiMC($soal, $jawaban, $bobot);
            case 'essay':
                return 0; // Nilai essay diisi manual
            default:
                return 0;
        }
    }

    private function hitungNilaiPG($soal, $jawaban, float $bobot): float
    {
        return $jawaban === $soal->kunci_pg ? $bobot : 0;
    }

    private function hitungNilaiMC($soal, $jawaban, float $bobot): float
    {
        $kunci_array = is_string($soal->kunci_multiple_choice)
            ? json_decode($soal->kunci_multiple_choice, true)
            : $soal->kunci_multiple_choice;

        if (!is_array($jawaban)) {
            return 0;
        }

        $jawaban_siswa = array_keys(array_filter($jawaban));
        sort($jawaban_siswa);

        $kunci_jawaban = array_keys(array_filter($kunci_array));
        $kunci_huruf = array_map(fn($key) => chr(65 + intval($key)), $kunci_jawaban);
        sort($kunci_huruf);

        return (!empty($kunci_huruf) && !empty($jawaban_siswa) && $kunci_huruf === $jawaban_siswa)
            ? $bobot
            : 0;
    }
}
