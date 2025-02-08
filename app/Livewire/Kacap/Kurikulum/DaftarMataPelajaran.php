<?php

namespace App\Livewire\Kacap\Kurikulum;

use App\Models\Akademik\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.kacapLayout')]
class DaftarMataPelajaran extends Component
{
    use WithPagination, Interactions;

    protected $listeners = ['refresh' => '$refresh'];

    // Pagination
    public $quantity = 10;
    protected $paginationTheme = 'tailwind';

    // Filters
    public $search = '';
    public $tingkatFilter = null;
    public $statusFilter = null;

    // Sorting
    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    protected function resetFilters(): void
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetFilters();
    }

    public function updatedTingkatFilter()
    {
        $this->resetFilters();
    }

    public function updatedStatusFilter()
    {
        $this->resetFilters();
    }

    public function delete(int $id): void
    {
        try {
            MataPelajaran::findOrFail($id)->delete();
            $this->success('Mata pelajaran berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus mata pelajaran');
        }
    }

    protected function getMataPelajaranData()
    {
        return MataPelajaran::with(['tentors', 'jadwalBelajars'])
            ->when($this->search, function ($query) {
                $query->where('nama_pelajaran', 'like', '%' . $this->search . '%')
                    ->orWhere('kode_pelajaran', 'like', '%' . $this->search . '%');
            })
            ->when($this->tingkatFilter, function ($query) {
                $query->where('tingkat', $this->tingkatFilter);
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {
        $mataPelajarans = $this->getMataPelajaranData();

        return view('livewire.kacap.kurikulum.daftar-mata-pelajaran', [
            'mataPelajarans' => $mataPelajarans
        ]);
    }

    public function updated()
    {
    }
}
