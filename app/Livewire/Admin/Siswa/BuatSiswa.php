<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Akademik\Kelas;
use App\Models\Akademik\KelasBimbel;
use App\Models\Users\Siswa;
use App\Models\User;
use App\Models\Cabang;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Layout('components.layouts.app')]
class BuatSiswa extends Component
{
    use Toast;
    use WithFileUploads;

    public $nama_lengkap;
    public $email;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $kelas_id;
    public $kelas_bimbel_id;
    public $cabang_id;
    public $no_telepon;
    public $asal_sekolah;
    public $kelas;
    public $nama_wali;
    public $jurusan;
    public $no_telepon_wali;
    public $tanggal_bergabung;
    public $foto;

    public function mount()
    {
        $this->tanggal_bergabung = now()->format('Y-m-d');
    }

    public function rules()
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'kelas_bimbel_id' => 'required|exists:kelas_bimbels,id',
            'cabang_id' => 'required|exists:cabangs,id',
            'no_telepon' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:255',
            'kelas' => 'required|string|max:10',
            'nama_wali' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:50',
            'no_telepon_wali' => 'required|string|max:15',
            'tanggal_bergabung' => 'required|date',
            'foto' => 'nullable|image|max:2048|mimes:jpg,jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
            'alamat.required' => 'Alamat harus diisi',
            'kelas_bimbel_id.required' => 'Kelas harus dipilih',
            'kelas_bimbel_id.exists' => 'Kelas tidak valid',
            'cabang_id.required' => 'Cabang harus dipilih',
            'cabang_id.exists' => 'Cabang tidak valid',
            'no_telepon.required' => 'Nomor telepon harus diisi',
            'no_telepon.max' => 'Nomor telepon maksimal 15 karakter',
            'asal_sekolah.required' => 'Asal sekolah harus diisi',
            'asal_sekolah.max' => 'Asal sekolah maksimal 255 karakter',
            'kelas.required' => 'Kelas harus diisi',
            'kelas.max' => 'Kelas maksimal 10 karakter',
            'nama_wali.required' => 'Nama wali harus diisi',
            'nama_wali.max' => 'Nama wali maksimal 255 karakter',
            'jurusan.max' => 'Jurusan maksimal 50 karakter',
            'no_telepon_wali.required' => 'Nomor telepon wali harus diisi',
            'no_telepon_wali.max' => 'Nomor telepon wali maksimal 15 karakter',
            'tanggal_bergabung.required' => 'Tanggal bergabung harus diisi',
            'tanggal_bergabung.date' => 'Format tanggal bergabung tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'foto.mimes' => 'Format foto harus jpg, jpeg, atau png',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Handle upload foto jika ada
        if ($this->foto) {
            $path = $this->foto->store('images/siswa', 'public');
            $validated['foto'] = $path;
        }

        // Buat data siswa
        Siswa::create([
            'password' => bcrypt($validated['email']),
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'kelas_bimbel_id' => $validated['kelas_bimbel_id'],
            'cabang_id' => $validated['cabang_id'],
            'no_telepon' => $validated['no_telepon'],
            'asal_sekolah' => $validated['asal_sekolah'],
            'kelas' => $validated['kelas'],
            'nama_wali' => $validated['nama_wali'],
            'jurusan' => $validated['jurusan'],
            'no_telepon_wali' => $validated['no_telepon_wali'],
            'tanggal_bergabung' => $validated['tanggal_bergabung'],
            'foto' => $validated['foto'] ?? null,
        ]);

        $this->success(
            title: 'Berhasil!',
            description: "Data siswa berhasil disimpan\nEmail: {$validated['email']}\nPassword"
        );

        $this->reset();
    }

    public function render()
    {
        return view('livewire.admin.siswa.buat-siswa', [
            'kelas_bimbels' => KelasBimbel::all(),
            'cabangs' => Cabang::all()
        ]);
    }
}
