<?php

namespace App\Livewire\Admin\KelasBimbel;

use Livewire\Component;
use App\Models\Akademik\KelasBimbel;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class DaftarKelasBimbel extends Component
{
    use WithPagination, Toast;

    // Search & Filter Properties
    public $search = '';
    public $status = '';
    public $sortBy = 'created_at';
    public $perPage = 10;

    // Modal Properties
    public $showModal = false;
    public $showDeleteModal = false;
    public $selectedKelas;
    public $editMode = false;

    // Form Properties
    #[Rule('required|min:3')]
    public $nama_kelas = '';

    #[Rule('nullable')]
    public $deskripsi;

    #[Rule('required')]
    public $program_bimbel = 'Reguler';

    #[Rule('required|numeric|min:1')]
    public $kapasitas = 20;

    #[Rule('required')]
    public $tingkat_kelas = 'X';
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['nama_kelas', 'deskripsi', 'program_bimbel', 'kapasitas', 
                     'tingkat_kelas', 'status', 'selectedKelas']);
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $kelasBimbel = KelasBimbel::findOrFail($id);
        $this->selectedKelas = $id;
        $this->nama_kelas = $kelasBimbel->nama_kelas;
        $this->deskripsi = $kelasBimbel->deskripsi;
        $this->program_bimbel = $kelasBimbel->program_bimbel;
        $this->kapasitas = $kelasBimbel->kapasitas;
        $this->tingkat_kelas = $kelasBimbel->tingkat_kelas;
        $this->status = $kelasBimbel->status;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_kelas' => $this->nama_kelas,
            'deskripsi' => $this->deskripsi,
            'program_bimbel' => $this->program_bimbel,
            'kapasitas' => $this->kapasitas,
            'tingkat_kelas' => $this->tingkat_kelas,
            'status' => $this->status,
        ];

        if ($this->selectedKelas) {
            KelasBimbel::find($this->selectedKelas)->update($data);
            $this->success('Kelas bimbel berhasil diperbarui');
        } else {
            KelasBimbel::create($data);
            $this->success('Kelas bimbel berhasil ditambahkan');
        }

        $this->showModal = false;
        $this->reset();
    }

    public function delete($id)
    {
        KelasBimbel::find($id)->delete();
        $this->showDeleteModal = false;
        $this->success('Kelas bimbel berhasil dihapus');
    }

    public function render()
    {
        $query = KelasBimbel::query()
            ->when($this->search, function ($query) {
                $query->where('nama_kelas', 'like', '%' . $this->search . '%')
                    ->orWhere('program_bimbel', 'like', '%' . $this->search . '%')
                    ->orWhere('tingkat_kelas', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            });

        // Handle sorting
        switch($this->sortBy) {
            case 'nama_asc':
                $query->orderBy('nama_kelas', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_kelas', 'desc');
                break;
            case 'kapasitas':
                $query->orderBy('kapasitas', 'desc');
                break;
            default:
                $query->latest();
        }

        $kelasBimbels = $query->paginate($this->perPage);

        return view('livewire.admin.kelas-bimbel.daftar-kelas-bimbel', [
            'kelasBimbels' => $kelasBimbels
        ]);
    }
}
