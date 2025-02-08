<?php

namespace App\Livewire\Kacap\Siswa;

use App\Models\Users\Siswa;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.kacapLayout')]
class ListSiswa extends Component
{
    use WithPagination, Toast;

    protected $listeners = ['refresh' => '$refresh'];

    // Pagination
    public $quantity = 10;
    protected $paginationTheme = 'tailwind';

    // Filters
    public $search = '';
    public $kelasFilter = null;
    public $statusFilter = null;

    // Sorting
    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    // Table Headers
    protected array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'nama', 'label' => 'Nama Siswa'],
        ['index' => 'kelas', 'label' => 'Kelas', 'sortable' => false],
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

    public function updatedKelasFilter()
    {
        $this->resetFilters();
    }

    public function updatedStatusFilter()
    {
        $this->resetFilters();
    }

    /**
     * Delete siswa record
     */
    public function delete(int $id): void
    {
        try {
            Siswa::findOrFail($id)->delete();
            $this->success('Siswa berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus siswa');
        }
    }

    /**
     * Get filtered and sorted siswa data
     */
    protected function getSiswaData()
    {
        $query = Siswa::query()
            ->when($this->search, function (Builder $query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->when($this->kelasFilter, function (Builder $query) {
                $query->where('kelas', $this->kelasFilter);
            })
            ->when($this->statusFilter, function (Builder $query) {
                $query->where('status', $this->statusFilter);
            });

        $query->orderBy($this->sort['column'], $this->sort['direction']);

        return $query->paginate($this->quantity);
    }

    public function render()
    {
        return view('livewire.kacap.siswa.list-siswa', [
            'headers' => $this->headers,
            'rows' => $this->getSiswaData()
        ]);
    }
}
