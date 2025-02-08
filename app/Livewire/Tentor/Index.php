<?php

namespace App\Livewire\Tentor;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Users\Siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;

#[Layout('components.layouts.TentorLayout')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $kelasBimbelId;
    public $tentorId;

    public function mount()
    {
        $this->tentorId = auth()->user()->id;
    }

    public function getJadwalPelajaransProperty()
    {
        return JadwalBelajar::with('kelasBimbel', 'mataPelajaran')
            ->where('tentor_id', $this->tentorId)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function getJadwalBelajarProperty()
    {
        return JadwalBelajar::with(['kelasBimbel', 'mataPelajaran'])
            ->where('tentor_id', $this->tentorId)
            ->orderBy('jam_mulai', 'asc')
            ->get();
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
        return view('livewire.tentor.index', [
            'jadwalPelajarans' => $this->jadwalPelajarans,
            'jadwalBelajar' => $this->jadwalBelajar
        ]);
    }
}
