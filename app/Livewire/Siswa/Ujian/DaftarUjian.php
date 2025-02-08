<?php

namespace App\Livewire\Siswa\Ujian;

use App\Services\Contracts\UjianServiceInterface;
use App\Services\Contracts\SiswaServiceInterface;
use App\Models\DaftarUjianSiswa;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.siswaLayout')]
class DaftarUjian extends Component
{
    use WithPagination, Toast;

    public $showPreviewModal = false;
    public $selectedUjian = null;
    /** @var UjianServiceInterface */
    protected UjianServiceInterface $ujianService;

    /** @var SiswaServiceInterface */
    protected SiswaServiceInterface $siswaService;

    public $headers = [
        'Nama Ujian',
        'Mata Pelajaran',
        'Status',
    ];

    public $rows = [];

    public string $search = '';
    public int $perPage = 10;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public ?string $mata_pelajaran = null;

    protected array $mataPelajarans = [
        ['id' => 1, 'nama_pelajaran' => 'Matematika'],
        ['id' => 2, 'nama_pelajaran' => 'Bahasa Indonesia'],
        ['id' => 3, 'nama_pelajaran' => 'Bahasa Inggris'],
        ['id' => 4, 'nama_pelajaran' => 'IPA'],
        ['id' => 5, 'nama_pelajaran' => 'IPS']
    ];

    public function boot(
        UjianServiceInterface $ujianService,
        SiswaServiceInterface $siswaService
    ): void {
        $this->ujianService = $ujianService;
        $this->siswaService = $siswaService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }

    public function mulaiUjian(int $ujianId): void
    {
        $daftarUjian = DaftarUjianSiswa::where('siswa_id', auth()->guard('siswa')->id())
            ->where('ujian_id', $ujianId)
            ->first();


        $this->redirect(route('siswa.ujian.on-ujian', ['id_ujian' => $daftarUjian->id]));
    }

    private function getUjians()
    {
        // Periksa apakah user sudah login
        if (!auth()->guard('siswa')->check()) {
            return redirect()->route('login.siswa');
        }

        // Periksa apakah user memiliki relasi siswa
        $user = auth()->guard('siswa')->user();
        if (!$user) {
            // Redirect ke halaman error atau tampilkan pesan error
            $this->error('Akun anda tidak memiliki akses sebagai siswa');
            return new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]),
                0,
                $this->perPage,
                1,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
        }

        // Dapatkan ID siswa yang sedang login
        $siswaId = auth()->guard('siswa')->user()->id;

        // Query untuk mendapatkan daftar ujian siswa
        return DaftarUjianSiswa::with(['ujian', 'mataPelajaran', 'siswa'])
            ->where('siswa_id', $siswaId)
            ->where('status', DaftarUjianSiswa::STATUS_BELUM_MULAI)
            ->when($this->search, function ($query) {
                $query->whereHas('ujian', function ($q) {
                    $q->where('nama', 'like', '%' . trim($this->search) . '%');
                });
            })
            ->when($this->mata_pelajaran, function ($query) {
                $query->where('mata_pelajaran_id', $this->mata_pelajaran);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    private function getPage()
    {
        return request()->query('page', 1);
    }

    private function getActiveUjianCount()
    {
        if (!auth()->guard('siswa')->check()) {
            return 0;
        }

        $siswaId = auth()->guard('siswa')->user()->id;

        return \App\Models\DaftarUjianSiswa::where('siswa_id', $siswaId)
            ->where('status', 'belum_mulai')
            ->count();
    }

    public function render()
    {
        return view('livewire.siswa.ujian.daftar-ujian', [
            'ujians' => $this->getUjians(),
            'mataPelajarans' => $this->mataPelajarans,
            'headers' => $this->headers,
            'rows' => $this->rows,
            'activeUjianCount' => $this->getActiveUjianCount()
        ]);
    }
}
