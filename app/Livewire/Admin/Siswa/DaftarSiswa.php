<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Siswa;

use App\Exports\SiswaExport;
use App\Models\Users\Siswa;
use App\Models\Akademik\KelasBimbel;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
class DaftarSiswa extends Component
{
    use WithPagination;
    use Toast;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public $selectedKelasBimbel = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
        'selectedKelasBimbel' => ['except' => ''],
    ];

    public function exportToExcel()
    {
        try {
            if (!$this->selectedKelasBimbel) {
                $this->error('Silakan pilih Kelas Bimbel terlebih dahulu sebelum melakukan export');
                return;
            }

            return (new SiswaExport($this->selectedKelasBimbel))
                ->download('daftar-siswa-' . now()->format('Y-m-d') . '.xlsx');
        } catch (\Exception $e) {
            $this->error('Gagal mengexport data siswa');
        }
    }

    public function getKelasBimbelOptions()
    {
        return KelasBimbel::orderBy('nama_kelas')->get();
    }

    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();

            $this->success('Siswa berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus siswa');
        }
    }

    public function redirectToDetail(int $id): void
    {
        $this->redirect(route('admin.siswa.show', $id), navigate: true);
    }

    public function render()
    {
        $siswa = Siswa::query()
            ->with(['cabang', 'kelasBimbel'])
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->whereHas('cabang', function ($q) {
                        $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('nama_lengkap', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedKelasBimbel, function ($query) {
                $query->where('kelas_bimbel_id', $this->selectedKelasBimbel);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.siswa.daftar-siswa', [
            'siswa' => $siswa,
            'kelasBimbelOptions' => $this->getKelasBimbelOptions()
        ]);
    }
}

