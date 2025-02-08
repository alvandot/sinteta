<?php

namespace App\Livewire\Kacap\Kelas;

use App\Models\Akademik\KelasBimbel;
use App\Models\Users\Siswa;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.kacapLayout')]
class Index extends Component
{
    use WithPagination, Toast;

    protected $listeners = ['refresh' => '$refresh'];

    // Pagination
    public $quantity = 10;
    protected $paginationTheme = 'tailwind';

    // Filters
    public $search = '';
    public $tingkatFilter = null;
    public $jenisFilter = null;
    public $statusFilter = null;

    // Sorting
    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    // Table Headers
    protected array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'nama_kelas', 'label' => 'Nama Kelas'],
        ['index' => 'tingkat_kelas', 'label' => 'Tingkat', 'sortable' => false],
        ['index' => 'total_siswa', 'label' => 'Total Siswa', 'sortable' => false],
        ['index' => 'status', 'label' => 'Status'],
        ['index' => 'action', 'label' => 'Aksi'],
    ];

    /**
     * Reset pagination when filters change
     */
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

    public function updatedJenisFilter()
    {
        $this->resetFilters();
    }

    public function updatedStatusFilter()
    {
        $this->resetFilters();
    }

    /**
     * Delete kelas bimbel record
     */
    public function delete(int $id): void
    {
        try {
            KelasBimbel::findOrFail($id)->delete();
            $this->success('Kelas berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus kelas');
        }
    }

    /**
     * Get filtered and sorted kelas bimbel data
     */
    protected function getKelasBimbelData()
    {
        $query = KelasBimbel::query()
            ->when($this->search, function (Builder $query) {
                $query->where('nama_kelas', 'like', '%' . $this->search . '%');
            })
            ->when($this->tingkatFilter, function (Builder $query) {
                $query->where('tingkat_kelas', $this->tingkatFilter);
            })
            ->when($this->jenisFilter, function (Builder $query) {
                $query->where('jenis_kelas', $this->jenisFilter);
            })
            ->when($this->statusFilter, function (Builder $query) {
                $query->where('status', $this->statusFilter);
            });

        // Only apply sorting if not sorting by total_siswa
        if ($this->sort['column'] !== 'total_siswa') {
            $query->orderBy($this->sort['column'], $this->sort['direction']);
        }

        return $query->paginate($this->quantity);
    }

    public function render()
    {
        $kelasBimbel = $this->getKelasBimbelData();
        $data = collect($kelasBimbel->items())->map(function ($item) {
            $item['total_siswa'] = Siswa::where('kelas_bimbel_id', $item->id)->count();
            return $item;
        });

        // Sort by total_siswa if selected
        if ($this->sort['column'] === 'total_siswa') {
            $data = $data->sortBy([
                'total_siswa' => $this->sort['direction'] === 'asc' ? SORT_ASC : SORT_DESC
            ]);
        }

        return view('livewire.kacap.kelas.index', [
            'headers' => $this->headers,
            'rows' => $kelasBimbel
        ]);
    }
}
