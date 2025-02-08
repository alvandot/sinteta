<?php

namespace App\Services\Contracts;

use App\Models\UjianSiswa;
use App\Models\Jawaban;
use App\Models\HasilUjian;
use App\Models\Soal\PaketSoal;
use App\Models\Akademik\Ujian;
use Illuminate\Support\Collection;

interface UjianServiceInterface
{
    /**
     * Get all UjianSiswa records
     *
     * @return Collection
     */
    public function getUjianSiswa(): Collection;

    /**
     * Get all Jawaban records
     *
     * @return Collection
     */
    public function getJawaban(): Collection;

    /**
     * Get all HasilUjian records
     *
     * @return Collection
     */
    public function getHasilUjian(): Collection;

    /**
     * Get all DaftarUjianSiswa records
     *
     * @return Collection
     */
    public function getDaftarUjianSiswa(): Collection;

    /**
     * Get all Soal records
     *
     * @return Collection
     */
    public function getSoal(): Collection;

    /**
     * Get all PaketSoal records
     *
     * @return Collection
     */
    public function getPaketSoal(): Collection;

    /**
     * Create a new UjianSiswa record
     *
     * @param array $data
     * @return UjianSiswa
     */
    public function createUjianSiswa(array $data): UjianSiswa;

    /**
     * Submit jawaban for UjianSiswa
     *
     * @param array $data
     * @return Jawaban
     */
    public function submitJawaban(array $data): Jawaban;

    /**
     * Calculate and create HasilUjian for UjianSiswa
     *
     * @param int $ujianSiswaId
     * @return HasilUjian
     */
    public function calculateHasilUjian(int $ujianSiswaId): HasilUjian;

    /**
     * Get UjianSiswa by ID with relations
     *
     * @param int $id
     * @return UjianSiswa|null
     */
    public function getUjianSiswaById(int $id): ?UjianSiswa;

    /**
     * Get PaketSoal by ID with relations
     *
     * @param int $id
     * @return PaketSoal|null
     */
    public function getPaketSoalById(int $id): ?PaketSoal;

    /**
     * Update UjianSiswa status
     *
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateUjianSiswaStatus(int $id, string $status): bool;

    /**
     * Get mata pelajaran options for dropdown
     *
     * @return array
     */
    public function getMataPelajaranOptions(): array;

    /**
     * Get kelas options for dropdown
     *
     * @return array
     */
    public function getKelasOptions(): array;

    /**
     * Create a new Ujian record
     *
     * @param array $data
     * @return Ujian
     */
    public function createUjian(array $data): Ujian;

    public function hitungNilai($soals, array $jawaban): float;
}
