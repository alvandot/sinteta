<?php

namespace App\Services\Implementations;

use App\Services\Contracts\AkademikServiceInterface;
use App\Models\Ujian;
use App\Models\MataPelajaran;
use App\Models\KelasBimbel;
use App\Models\JadwalBelajar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AkademikService implements AkademikServiceInterface
{
    protected $ujian;
    protected $mataPelajaran;
    protected $kelasBimbel;
    protected $jadwalBelajar;

    public function __construct(
        Ujian $ujian,
        MataPelajaran $mataPelajaran,
        KelasBimbel $kelasBimbel,
        JadwalBelajar $jadwalBelajar
    ) {
        $this->ujian = $ujian;
        $this->mataPelajaran = $mataPelajaran;
        $this->kelasBimbel = $kelasBimbel;
        $this->jadwalBelajar = $jadwalBelajar;
    }

    /**
     * Get all Ujian records with relations
     *
     * @return Collection
     */
    public function getUjian(): Collection
    {
        return $this->ujian->with(['mataPelajaran', 'paketSoal'])->get();
    }

    /**
     * Get all MataPelajaran records
     *
     * @return Collection
     */
    public function getMataPelajaran(): Collection
    {
        return $this->mataPelajaran->with(['tentor'])->get();
    }

    /**
     * Get all KelasBimbel records
     *
     * @return Collection
     */
    public function getKelasBimbel(): Collection
    {
        return $this->kelasBimbel->with(['siswa', 'jadwalBelajar'])->get();
    }

    /**
     * Get all JadwalBelajar records
     *
     * @return Collection
     */
    public function getJadwalBelajar(): Collection
    {
        return $this->jadwalBelajar->with(['kelasBimbel', 'mataPelajaran', 'tentor'])->get();
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
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'paket_soal_id' => 'required|exists:paket_soal,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                return $this->ujian->create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat ujian: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing Ujian record
     *
     * @param int $id
     * @param array $data
     * @return Ujian
     * @throws ValidationException
     */
    public function updateUjian(int $id, array $data): Ujian
    {
        $ujian = $this->ujian->findOrFail($id);

        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'paket_soal_id' => 'required|exists:paket_soal,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'durasi' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,archived'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($ujian, $data) {
                $ujian->update($data);
                return $ujian->fresh(['mataPelajaran', 'paketSoal']);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupdate ujian: ' . $e->getMessage());
        }
    }

    /**
     * Delete an Ujian record
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteUjian(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $ujian = $this->ujian->findOrFail($id);
                return $ujian->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghapus ujian: ' . $e->getMessage());
        }
    }

    /**
     * Create a new JadwalBelajar record
     *
     * @param array $data
     * @return JadwalBelajar
     * @throws ValidationException
     */
    public function createJadwalBelajar(array $data): JadwalBelajar
    {
        $validator = Validator::make($data, [
            'kelas_bimbel_id' => 'required|exists:kelas_bimbel,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tentor_id' => 'required|exists:tentor,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($data) {
                return $this->jadwalBelajar->create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal membuat jadwal belajar: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing JadwalBelajar record
     *
     * @param int $id
     * @param array $data
     * @return JadwalBelajar
     * @throws ValidationException
     */
    public function updateJadwalBelajar(int $id, array $data): JadwalBelajar
    {
        $jadwalBelajar = $this->jadwalBelajar->findOrFail($id);

        $validator = Validator::make($data, [
            'kelas_bimbel_id' => 'required|exists:kelas_bimbel,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tentor_id' => 'required|exists:tentor,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return DB::transaction(function () use ($jadwalBelajar, $data) {
                $jadwalBelajar->update($data);
                return $jadwalBelajar->fresh(['kelasBimbel', 'mataPelajaran', 'tentor']);
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal mengupdate jadwal belajar: ' . $e->getMessage());
        }
    }

    /**
     * Delete a JadwalBelajar record
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteJadwalBelajar(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $jadwalBelajar = $this->jadwalBelajar->findOrFail($id);
                return $jadwalBelajar->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception('Gagal menghapus jadwal belajar: ' . $e->getMessage());
        }
    }
}
