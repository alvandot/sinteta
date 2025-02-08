<?php

namespace App\Services\Contracts;

use App\Models\Akademik\Ujian;
use App\Models\Akademik\JadwalBelajar;
use Illuminate\Support\Collection;

interface AkademikServiceInterface
{
    /**
     * Get all Ujian records with relations
     *
     * @return Collection
     */
    public function getUjian(): Collection;

    /**
     * Get all MataPelajaran records
     *
     * @return Collection
     */
    public function getMataPelajaran(): Collection;

    /**
     * Get all KelasBimbel records
     *
     * @return Collection
     */
    public function getKelasBimbel(): Collection;

    /**
     * Get all JadwalBelajar records
     *
     * @return Collection
     */
    public function getJadwalBelajar(): Collection;

    /**
     * Create a new Ujian record
     *
     * @param array $data
     * @return Ujian
     */
    public function createUjian(array $data): Ujian;

    /**
     * Update an existing Ujian record
     *
     * @param int $id
     * @param array $data
     * @return Ujian
     */
    public function updateUjian(int $id, array $data): Ujian;

    /**
     * Delete an Ujian record
     *
     * @param int $id
     * @return bool
     */
    public function deleteUjian(int $id): bool;

    /**
     * Create a new JadwalBelajar record
     *
     * @param array $data
     * @return JadwalBelajar
     */
    public function createJadwalBelajar(array $data): JadwalBelajar;

    /**
     * Update an existing JadwalBelajar record
     *
     * @param int $id
     * @param array $data
     * @return JadwalBelajar
     */
    public function updateJadwalBelajar(int $id, array $data): JadwalBelajar;

    /**
     * Delete a JadwalBelajar record
     *
     * @param int $id
     * @return bool
     */
    public function deleteJadwalBelajar(int $id): bool;
}
