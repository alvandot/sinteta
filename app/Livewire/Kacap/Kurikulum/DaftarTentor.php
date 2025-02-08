<?php

namespace App\Livewire\Kacap\Kurikulum;

use App\Models\Users\Tentor;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;
use App\Models\Kurikulum\MataPelajaran;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.kacapLayout')]
class DaftarTentor extends Component
{
    use WithPagination, Interactions;

    protected $listeners = ['refresh' => '$refresh'];

    // Pagination
    public $quantity = 10;
    protected $paginationTheme = 'tailwind';

    // Filters
    public $search = '';
    public $mapelFilter = null;
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

    public function updatedMapelFilter()
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
            Tentor::findOrFail($id)->delete();
            $this->success('Tentor berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus tentor');
        }
    }

    protected function getTentorData()
    {
        return Tentor::with(['mapels', 'jadwalBelajars'])
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('spesialisasi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('mapels', function ($q) {
                        $q->where('nama_pelajaran', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->mapelFilter, function ($query) {
                $query->whereHas('mapels', function ($q) {
                    $q->where('id', $this->mapelFilter);
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sort['column'], $this->sort['direction'])
            ->paginate($this->quantity);
    }

    public function render()
    {


        return view('livewire.kacap.kurikulum.daftar-tentor', [
            'tentors' => $this->getTentorData()
        ]);
    }

    // Ketika ada perubahan data, hapus cache
    public function updated()
    {
    }
}
