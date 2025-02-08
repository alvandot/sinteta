<?php

namespace App\Livewire\Siswa;

use App\Models\Users\Siswa;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use TallStackUi\Traits\Interactions;

#[Layout('components.layouts.siswaLayout')]
class Index extends Component
{
    use Interactions;

    public $jadwalBelajar;
    public $ujian;
    public $jadwalBelajars;
    public $ujians;
    protected $siswa;

    public function mount()
    {
        // Dummy data untuk jadwal belajar
        $this->jadwalBelajars = collect([
            [
                'id' => 1,
                'nama_jadwal' => 'Matematika Kelas X',
                'mata_pelajaran' => 'Matematika',
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:30',
                'ruangan' => 'Ruang A1',
                'tentor' => 'Pak Budi'
            ],
            [
                'id' => 2,
                'nama_jadwal' => 'Fisika Kelas X',
                'mata_pelajaran' => 'Fisika',
                'hari' => 'Selasa',
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:30',
                'ruangan' => 'Lab Fisika',
                'tentor' => 'Bu Ani'
            ]
        ]);

        // Dummy data untuk ujian
        $this->ujians = collect([
            [
                'id' => 1,
                'nama_ujian' => 'UTS Matematika',
                'mata_pelajaran' => 'Matematika',
                'tanggal' => '2024-01-20',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
                'ruangan' => 'Ruang Ujian 1',
                'status' => 'Belum dimulai'
            ],
            [
                'id' => 2,
                'nama_ujian' => 'UTS Fisika',
                'mata_pelajaran' => 'Fisika',
                'tanggal' => '2024-01-21',
                'waktu_mulai' => '10:00',
                'waktu_selesai' => '12:00',
                'ruangan' => 'Ruang Ujian 2',
                'status' => 'Belum dimulai'
            ]
        ]);
    }

    protected function getSiswa()
    {
        return Siswa::with([
            'jadwalBelajarSiswas',
            'jadwalUjianSiswas'
        ])->find(auth()->hasRole('siswa')->user()->id);
    }

    protected function loadData()
    {
        // Data sudah di-load di mount() dengan dummy data
    }

    public function render()
    {
        return view('livewire.siswa.index');
    }
}
