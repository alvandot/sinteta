<?php

namespace App\Livewire\Siswa\Jadwal;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Users\Siswa;
use Illuminate\Support\Collection;

#[Layout('components.layouts.siswaLayout')]
class DaftarJadwal extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $kelasBimbelId;

    public function mount()
    {
        
        $this->kelasBimbelId = auth()->guard('siswa')->user()->kelas_bimbel_id;
    }

    public function getJadwalPelajaransProperty()
    {
        return JadwalBelajar::with('kelasBimbel', 'mataPelajaran')
            ->where('kelas_bimbel_id', $this->kelasBimbelId)
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
        return view('livewire.siswa.jadwal.daftar-jadwal', [
            'jadwalPelajarans' => $this->jadwalPelajarans
        ]);
    }
}
