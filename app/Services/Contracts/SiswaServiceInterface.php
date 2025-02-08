<?php

namespace App\Services\Contracts;

interface SiswaServiceInterface
{
    public function getAllSiswa();
    public function getSiswaById(int $id);
    public function createSiswa(array $data);
    public function updateSiswa(int $id, array $data);
    public function deleteSiswa(int $id);
    public function getUjianSiswa(int $siswaId);
    public function getHasilUjian(int $siswaId);
    public function getJadwalBelajar(int $siswaId);
    public function getKelasBimbel(int $siswaId);
}
