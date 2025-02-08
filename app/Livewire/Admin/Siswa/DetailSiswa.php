<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Users\Siswa;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Storage;

#[Layout('components.layouts.app')]
class DetailSiswa extends Component
{
    use WithFileUploads;
    use Toast;

    public ?Siswa $siswa = null;
    public ?string $foto = null;
    public bool $isEditing = false;

    // Tambahkan properti untuk form editing
    public $form = [
        'nama_lengkap' => '',
        'email' => '',
        'no_telepon' => '',
        'jenis_kelamin' => '',
        'asal_sekolah' => '',
        'kelas' => '',
    ];

    public function mount(int $id): void
    {
        $this->siswa = Siswa::with(['cabang', 'kelasBimbel'])->findOrFail($id);
        $this->initForm();
    }

    protected function initForm(): void
    {
        $this->form = [
            'nama_lengkap' => $this->siswa->nama_lengkap,
            'email' => $this->siswa->email,
            'no_telepon' => $this->siswa->no_telepon,
            'jenis_kelamin' => $this->siswa->jenis_kelamin,
            'asal_sekolah' => $this->siswa->asal_sekolah,
            'kelas' => $this->siswa->kelas,
        ];
    }

    public function updateFoto(): void
    {
        try {
            $this->validate([
                'foto' => 'required|image|max:2048'
            ]);

            if ($this->siswa->foto) {
                Storage::delete($this->siswa->foto);
            }

            $path = $this->foto->store('public/siswa/foto');
            $this->siswa->update([
                'foto' => $path
            ]);

            $this->success('Foto berhasil diperbarui');
            $this->reset('foto');
        } catch (\Exception $e) {
            $this->error('Gagal memperbarui foto');
        }
    }

    public function updateStatus(string $status): void
    {
        try {
            $this->siswa->update([
                'status' => $status
            ]);

            $this->success('Status berhasil diperbarui');
        } catch (\Exception $e) {
            $this->error('Gagal memperbarui status');
        }
    }

    public function delete(): void
    {
        try {
            if ($this->siswa->foto) {
                Storage::delete($this->siswa->foto);
            }

            $this->siswa->delete();

            $this->success('Siswa berhasil dihapus');
            $this->redirectRoute('admin.siswa.index', navigate: true);
        } catch (\Exception $e) {
            $this->error('Gagal menghapus siswa');
        }
    }

    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if ($this->isEditing) {
            $this->initForm();
        }
    }

    public function updateField($field): void
    {
        try {
            $this->siswa->update([
                $field => $this->form[$field]
            ]);

            $this->success('Data berhasil diperbarui');
        } catch (\Exception $e) {
            $this->error('Gagal memperbarui data');
        }
    }

    public function render()
    {
        return view('livewire.admin.siswa.detail-siswa');
    }
}
