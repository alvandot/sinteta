<?php

namespace App\Services\Implementations;

use App\Services\Contracts\TentorServiceInterface;
use App\Models\Users\Tentor;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\MataPelajaran;

class TentorService implements TentorServiceInterface
{
    public function getAllTentor()
    {
        return Tentor::with(['user', 'mataPelajaran'])->get();
    }

    public function getTentorById(int $id)
    {
        return Tentor::with(['user', 'mataPelajaran'])->findOrFail($id);
    }

    public function createTentor(array $data)
    {
        return Tentor::create($data);
    }

    public function updateTentor(int $id, array $data)
    {
        $tentor = Tentor::findOrFail($id);
        $tentor->update($data);
        return $tentor;
    }

    public function deleteTentor(int $id)
    {
        return Tentor::findOrFail($id)->delete();
    }

    public function getJadwalMengajar(int $tentorId)
    {
        return JadwalBelajar::where('tentor_id', $tentorId)
            ->with(['kelasBimbel', 'mataPelajaran'])
            ->get();
    }

    public function getKelasDiampu(int $tentorId)
    {
        return KelasBimbel::where('tentor_id', $tentorId)
            ->with(['siswa', 'mataPelajaran'])
            ->get();
    }

    public function getMataPelajaran(int $tentorId)
    {
        return Tentor::findOrFail($tentorId)->mataPelajaran;
    }

    public function assignMataPelajaran(int $tentorId, array $mataPelajaranIds)
    {
        $tentor = Tentor::findOrFail($tentorId);
        $tentor->mataPelajaran()->sync($mataPelajaranIds);
        return $tentor->mataPelajaran;
    }

    public function removeMataPelajaran(int $tentorId, int $mataPelajaranId)
    {
        $tentor = Tentor::findOrFail($tentorId);
        $tentor->mataPelajaran()->detach($mataPelajaranId);
        return true;
    }
}
