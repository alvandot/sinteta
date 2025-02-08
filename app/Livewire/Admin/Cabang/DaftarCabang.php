<?php

namespace App\Livewire\Admin\Cabang;

use App\Models\Cabang;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class DaftarCabang extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    public $cabangId;
    public $showDetailModal = false;
    public $selectedCabang = null;

    #[Rule('required|min:3|max:100')]
    public $nama_cabang = '';

    #[Rule('required|min:5')]
    public $alamat = '';

    #[Rule('required|numeric')]
    public $kontak = '';

    public function create()
    {
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit(Cabang $cabang)
    {
        $this->editMode = true;
        $this->cabangId = $cabang->id;
        $this->nama_cabang = $cabang->nama;
        $this->alamat = $cabang->alamat;
        $this->kontak = $cabang->kontak;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $cabang = Cabang::find($this->cabangId);
            $cabang->update([
                'nama' => $this->nama_cabang,
                'alamat' => $this->alamat,
                'kontak' => $this->kontak,
            ]);
            $this->dispatch('notify', [
                'message' => 'Cabang berhasil diperbarui!',
                'type' => 'success'
            ]);
        } else {
            Cabang::create([
                'nama' => $this->nama_cabang,
                'alamat' => $this->alamat,
                'kontak' => $this->kontak,
            ]);
            $this->dispatch('notify', [
                'message' => 'Cabang berhasil ditambahkan!',
                'type' => 'success'
            ]);
        }

        $this->reset();
        $this->showModal = false;
    }

    public function delete(Cabang $cabang)
    {
        $cabang->delete();
        $this->dispatch('notify', [
            'message' => 'Cabang berhasil dihapus!',
            'type' => 'success'
        ]);
    }

    public function showDetail($id)
    {
        return redirect()->route('admin.cabang.show', $id);
    }

    public function render()
    {
        $cabangs = Cabang::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.admin.cabang.daftar-cabang', [
            'cabangs' => $cabangs
        ]);
    }
}
