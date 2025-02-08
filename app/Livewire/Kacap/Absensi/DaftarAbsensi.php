<?php

declare(strict_types=1);

namespace App\Livewire\Kacap\Absensi;

use App\Models\Akademik\Absensi;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\MataPelajaran;
use App\Models\Users\Siswa;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Carbon\Carbon;
use Spatie\LaravelPdf\Facades\Pdf;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.kacapLayout')]
class DaftarAbsensi extends Component
{
    use WithPagination;
    use Toast;

    public $search = '';
    public $filterTanggal = '';
    public $filterStatus = '';
    public $filterMapel = '';

    // Properti untuk export PDF
    public $tanggalMulai = '';
    public $tanggalSelesai = '';
    public $exportStatus = '';
    public $exportMapel = '';
    public $exportSiswa = '';
    public $exportTentor = '';
    public $showExportModal = false;
    public $sortBy = 'tanggal'; // Default sort by tanggal
    public $sortDirection = 'desc'; // Default sort direction
    public $perPage = 50; // Default items per page for PDF

    public $absensi_id;
    public $jadwal_belajar_id;
    public $siswa_id;
    public $tentor_id;
    public $mata_pelajaran_id;
    public $status;
    public $keterangan;
    public $catatan_pembelajaran;
    public $tanggal;

    public $isModalOpen = false;

    protected $rules = [
        'jadwal_belajar_id' => 'required|exists:jadwal_belajars,id',
        'siswa_id' => 'required|exists:siswas,id',
        'tentor_id' => 'required|exists:users,id',
        'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        'status' => 'required|in:hadir,izin,sakit,alpha',
        'keterangan' => 'nullable|string',
        'catatan_pembelajaran' => 'nullable|string',
        'tanggal' => 'required|date',
    ];

    public function showExportDialog()
    {
        $this->reset(['tanggalMulai', 'tanggalSelesai', 'exportStatus', 'exportMapel', 'exportSiswa', 'exportTentor', 'sortBy', 'sortDirection', 'perPage']);
        $this->showExportModal = true;
    }

    public function exportPDF()
    {
        $this->validate([
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'required|date|after_or_equal:tanggalMulai',
            'perPage' => 'required|integer|min:1|max:1000',
        ], [
            'tanggalMulai.required' => 'Tanggal mulai harus diisi',
            'tanggalSelesai.required' => 'Tanggal selesai harus diisi',
            'tanggalSelesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'perPage.required' => 'Jumlah data per halaman harus diisi',
            'perPage.integer' => 'Jumlah data per halaman harus berupa angka',
            'perPage.min' => 'Jumlah data per halaman minimal 1',
            'perPage.max' => 'Jumlah data per halaman maksimal 1000',
        ]);
$query = Absensi::query()
                ->whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalSelesai])
                ->when($this->exportStatus, function ($query) {
                    $query->where('status', $this->exportStatus);
                })
                ->when($this->exportMapel, function ($query) {
                    $query->where('mata_pelajaran_id', $this->exportMapel);
                })
                ->when($this->exportSiswa, function ($query) {
                    $query->where('siswa_id', $this->exportSiswa);
                })
                ->when($this->exportTentor, function ($query) {
                    $query->where('tentor_id', $this->exportTentor);
                })
                ->with(['siswa', 'tentor', 'mataPelajaran', 'jadwalBelajar']);

            // Apply sorting
            $query->orderBy($this->sortBy, $this->sortDirection);

            // Get paginated results
            $absensiData = $query->paginate($this->perPage);

            $pdf = Pdf::view('pdf.absensi', [
                'absensiList' => $absensiData,
                'tanggalMulai' => Carbon::parse($this->tanggalMulai)->format('d/m/Y'),
                'tanggalSelesai' => Carbon::parse($this->tanggalSelesai)->format('d/m/Y'),
                'filterInfo' => $this->getFilterInfo(),
            ])->format('a4')->save('laporan-absensi-' . Carbon::now()->format('d-m-Y') . '.pdf');

            $this->showExportModal = false;

            return response()->download('laporan-absensi-' . Carbon::now()->format('d-m-Y') . '.pdf');

    }

    private function getFilterInfo()
    {
        $filters = [];

        if ($this->exportStatus) {
            $filters[] = 'Status: ' . ucfirst($this->exportStatus);
        }

        if ($this->exportMapel) {
            $mapel = MataPelajaran::find($this->exportMapel);
            if ($mapel) {
                $filters[] = 'Mata Pelajaran: ' . $mapel->nama_pelajaran;
            }
        }

        if ($this->exportSiswa) {
            $siswa = Siswa::find($this->exportSiswa);
            if ($siswa) {
                $filters[] = 'Siswa: ' . $siswa->nama_lengkap;
            }
        }

        if ($this->exportTentor) {
            $tentor = User::find($this->exportTentor);
            if ($tentor) {
                $filters[] = 'Tentor: ' . $tentor->name;
            }
        }

        return implode(' | ', $filters);
    }

    #[Computed]
    public function daftarAbsensi()
    {
        return Absensi::query()
            ->when($this->search, function ($query) {
                $query->whereHas('siswa', function ($q) {
                    $q->where('nama_lengkap', 'like', '%' . $this->search . '%');
                })->orWhereHas('tentor', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterTanggal, function ($query) {
                $query->whereDate('tanggal', Carbon::parse($this->filterTanggal));
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->filterMapel, function ($query) {
                $query->where('mata_pelajaran_id', $this->filterMapel);
            })
            ->with(['siswa', 'tentor', 'mataPelajaran', 'jadwalBelajar'])
            ->latest('tanggal')
            ->paginate(10);
    }

    #[Computed]
    public function daftarMapel()
    {
        return MataPelajaran::all();
    }

    #[Computed]
    public function jadwalBelajarList()
    {
        return JadwalBelajar::query()
            ->with(['mataPelajaran', 'tentor'])
            ->get();
    }

    #[Computed]
    public function siswaList()
    {
        return Siswa::all();
    }

    #[Computed]
    public function tentorList()
    {
        return User::query()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'tentor');
            })
            ->get();
    }

    public function create()
    {
        $this->reset();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $this->absensi_id = $id;
        $this->jadwal_belajar_id = $absensi->jadwal_belajar_id;
        $this->siswa_id = $absensi->siswa_id;
        $this->tentor_id = $absensi->tentor_id;
        $this->mata_pelajaran_id = $absensi->mata_pelajaran_id;
        $this->status = $absensi->status;
        $this->keterangan = $absensi->keterangan;
        $this->catatan_pembelajaran = $absensi->catatan_pembelajaran;
        $this->tanggal = $absensi->tanggal->format('Y-m-d');

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        try {
            Absensi::updateOrCreate(
                ['id' => $this->absensi_id],
                [
                    'jadwal_belajar_id' => $this->jadwal_belajar_id,
                    'siswa_id' => $this->siswa_id,
                    'tentor_id' => $this->tentor_id,
                    'mata_pelajaran_id' => $this->mata_pelajaran_id,
                    'status' => $this->status,
                    'keterangan' => $this->keterangan,
                    'catatan_pembelajaran' => $this->catatan_pembelajaran,
                    'tanggal' => $this->tanggal,
                ]
            );

            $this->success('Data absensi berhasil disimpan');
            $this->isModalOpen = false;
            $this->reset();
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Absensi::findOrFail($id)->delete();
            $this->success('Data absensi berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.kacap.absensi.daftar-absensi', [
            'absensiList' => $this->daftarAbsensi,
            'mataPelajaranList' => $this->daftarMapel,
            'jadwalBelajarList' => $this->jadwalBelajarList,
            'siswaList' => $this->siswaList,
            'tentorList' => $this->tentorList,
        ]);
    }
}
