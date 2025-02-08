<?php

namespace App\Services\Implementations;

use App\Services\Contracts\SiswaServiceInterface;
use App\Models\Users\Siswa;
use App\Models\UjianSiswa;
use App\Models\HasilUjian;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;

class SiswaService implements SiswaServiceInterface
{
    public function getAllSiswa()
    {
        return Siswa::with(['user', 'kelasBimbel'])->get();
    }

    public function getSiswaById(int $id)
    {
        return Siswa::with(['user', 'kelasBimbel'])->findOrFail($id);
    }

    public function createSiswa(array $data)
    {
        return Siswa::create($data);
    }

    public function updateSiswa(int $id, array $data)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->update($data);
        return $siswa;
    }

    public function deleteSiswa(int $id)
    {
        return Siswa::findOrFail($id)->delete();
    }

    public function getUjianSiswa(int $siswaId)
    {
        return UjianSiswa::where('siswa_id', $siswaId)
            ->with(['ujian', 'hasilUjian'])
            ->get();
    }

    public function getHasilUjian(int $siswaId)
    {
        return HasilUjian::whereHas('ujianSiswa', function($query) use ($siswaId) {
            $query->where('siswa_id', $siswaId);
        })->with('ujianSiswa.ujian')->get();
    }

    public function getJadwalBelajar(int $siswaId)
    {
        return JadwalBelajar::whereHas('kelasBimbel.siswa', function($query) use ($siswaId) {
            $query->where('id', $siswaId);
        })->with(['mataPelajaran', 'tentor'])->get();
    }

    public function getKelasBimbel(int $siswaId)
    {
        return KelasBimbel::whereHas('siswa', function($query) use ($siswaId) {
            $query->where('id', $siswaId);
        })->with(['mataPelajaran', 'tentor'])->get();
    }
}
