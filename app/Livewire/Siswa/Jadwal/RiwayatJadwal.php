<?php

namespace App\Livewire\Siswa\Jadwal;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Users\Siswa;

#[Layout('components.layouts.siswaLayout')]
class RiwayatJadwal extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $kelasBimbelId;

    public function mount()
    {
        $this->kelasBimbelId = auth()->guard('siswa')->user()->kelasBimbel->id;
    }

    public function getRiwayatJadwalProperty()
    {
        return JadwalBelajar::with('kelasBimbel', 'mataPelajaran')
            ->where('kelas_bimbel_id', $this->kelasBimbelId)
            ->where('status', 'selesai')
            ->when($this->search, function ($query) {
                $query->whereHas('mataPelajaran', function ($q) {
                    $q->where('nama_pelajaran', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('ruangan', 'like', '%' . $this->search . '%')
                    ->orWhere('kelas', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function render()
    {
        return view('livewire.siswa.jadwal.riwayat-jadwal', [
            'riwayatJadwal' => $this->riwayatJadwal
        ]);
    }
}
