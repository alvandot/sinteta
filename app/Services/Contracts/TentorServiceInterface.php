<?php

namespace App\Services\Contracts;

interface TentorServiceInterface
{
    public function getAllTentor();
    public function getTentorById(int $id);
    public function createTentor(array $data);
    public function updateTentor(int $id, array $data);
    public function deleteTentor(int $id);
    public function getJadwalMengajar(int $tentorId);
    public function getKelasDiampu(int $tentorId);
    public function getMataPelajaran(int $tentorId);
    public function assignMataPelajaran(int $tentorId, array $mataPelajaranIds);
    public function removeMataPelajaran(int $tentorId, int $mataPelajaranId);
}
