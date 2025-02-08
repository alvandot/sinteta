<?php

namespace App\Livewire\Admin\MataPelajaran;

use App\Models\Akademik\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
class DaftarMataPelajaran extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_pelajaran = '';
    public $kode_pelajaran = '';
    public $deskripsi = '';
    public $selectedMapel;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $showPreviewModal = false;
    public $selectedMapelData;

    protected $rules = [
        'nama_pelajaran' => 'required|min:3',
        'kode_pelajaran' => 'required|min:2|max:10|unique:mata_pelajarans,kode_pelajaran',
        'deskripsi' => 'nullable'
    ];

    public function render()
    {
        $mataPelajarans = MataPelajaran::where('nama_pelajaran', 'like', '%' . $this->search . '%')
            ->orWhere('kode_pelajaran', 'like', '%' . $this->search . '%')
            ->orderBy('nama_pelajaran')
            ->paginate(10);

        return view('livewire.admin.mata-pelajaran.daftar-mata-pelajaran', [
            'mataPelajarans' => $mataPelajarans
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $this->selectedMapel = $id;
        $this->nama_pelajaran = $mataPelajaran->nama_pelajaran;
        $this->kode_pelajaran = $mataPelajaran->kode_pelajaran;
        $this->deskripsi = $mataPelajaran->deskripsi;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['kode_pelajaran'] = 'required|min:2|max:10|unique:mata_pelajarans,kode_pelajaran,' . $this->selectedMapel;
        }

        $this->validate();

        if ($this->editMode) {
            $mataPelajaran = MataPelajaran::find($this->selectedMapel);
            $mataPelajaran->update([
                'nama_pelajaran' => $this->nama_pelajaran,
                'kode_pelajaran' => $this->kode_pelajaran,
                'deskripsi' => $this->deskripsi
            ]);
        } else {
            MataPelajaran::create([
                'nama_pelajaran' => $this->nama_pelajaran,
                'kode_pelajaran' => $this->kode_pelajaran,
                'deskripsi' => $this->deskripsi,
                'is_active' => true
            ]);
        }

        $this->showModal = false;
        $this->resetInputFields();
    }

    public function delete($id)
    {
        MataPelajaran::find($id)->delete();
        $this->showDeleteModal = false;
    }

    public function preview($id)
    {
        $this->selectedMapelData = MataPelajaran::find($id);
        $this->showPreviewModal = true;
    }

    private function resetInputFields()
    {
        $this->nama_pelajaran = '';
        $this->kode_pelajaran = '';
        $this->deskripsi = '';
        $this->selectedMapel = null;
    }
}
