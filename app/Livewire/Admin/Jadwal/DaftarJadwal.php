<?php

namespace App\Livewire\Admin\Jadwal;

use Livewire\Component;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\MataPelajaran;
use App\Models\Users\Tentor;
use App\Models\Akademik\KelasBimbel;
use Mary\Traits\Toast;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use Spatie\LaravelPdf\Facades\Pdf as PdfFacade;


#[Layout('components.layouts.app')]
class DaftarJadwal extends Component
{
    use Toast;
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'tanggal_mulai';
    public $sortDirection = 'desc';
    public $filterDate = null;
    public $hasMorePages = false;
    public $modalPreview = false;
    public $selectedJadwal = null;

    // Form Properties
    public $jadwal_id;
    public $nama_jadwal;
    public $tanggal_mulai;
    public $mata_pelajaran_id;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $ruangan;
    public $kelas;
    public $tentor_id;
    public $kapasitas;
    public $jumlah_siswa = 0;
    public $status = 'aktif';
    public $catatan;
    public $kelas_bimbel_id;

    // Lists for Dropdowns
    public $mata_pelajarans = [];
    public $tentors = [];
    public $kelas_bimbels = [];

    // Modal States
    public $modalCreate = false;
    public $modalEdit = false;
    public $modalDelete = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $rules = [
        'nama_jadwal' => 'required|string|max:255',
        'tanggal_mulai' => 'required|date',
        'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        'hari' => 'required|string',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
        'ruangan' => 'required|string',
        'kelas' => 'required|string',
        'tentor_id' => 'required|exists:tentors,id',
        'kapasitas' => 'required|integer|min:1',
        'status' => 'required|string',
        'catatan' => 'nullable|string',
        'kelas_bimbel_id' => 'required|exists:kelas_bimbels,id',
    ];

    public function mount()
    {
        $this->mata_pelajarans = MataPelajaran::all();
        $this->tentors = Tentor::all();
        $this->kelas_bimbels = KelasBimbel::all();
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function resetForm()
    {
        $this->reset([
            'jadwal_id',
            'nama_jadwal',
            'tanggal_mulai',
            'mata_pelajaran_id',
            'hari',
            'jam_mulai',
            'jam_selesai',
            'ruangan',
            'kelas',
            'tentor_id',
            'kapasitas',
            'status',
            'catatan',
            'kelas_bimbel_id'
        ]);
        $this->resetValidation();
    }

    public function create()
    {
        return $this->redirect('/admin/jadwal/buat');
    }

    public function edit($id)
    {
        return $this->redirect('/admin/jadwal/' . $id . '/edit');
    }

    public function confirmDelete($id)
    {
        try {
            JadwalBelajar::findOrFail($id)->delete();
            $this->success('Jadwal berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan saat menghapus jadwal');
        }
    }

    public function preview($id)
    {
        $this->selectedJadwal = JadwalBelajar::with(['mataPelajaran', 'tentor', 'kelasBimbel.siswa'])
            ->findOrFail($id);

        $this->modalPreview = true;
    }

    public function closePreview()
    {
        $this->selectedJadwal = null;
        $this->modalPreview = false;
    }

    public function exportPDF()
    {
        if (!$this->selectedJadwal) {
            $this->error('Tidak ada jadwal yang dipilih');
            return;
        }

        $jadwal = JadwalBelajar::with(['mataPelajaran', 'tentor.user', 'kelasBimbel.siswa'])
            ->findOrFail($this->selectedJadwal->id);

        $pdf = PdfFacade::view('pdfs.jadwal-detail', ['jadwal' => $jadwal])
            ->format('a4')
            ->save('jadwal_' . $jadwal->nama_jadwal . '.pdf');

        return response()->download('jadwal.pdf');
    }

    public function exportJadwalByDate()
    {
        if (!$this->filterDate) {
            $this->error('Pilih tanggal terlebih dahulu');
            return;
        }

          $jadwals = JadwalBelajar::whereDate('tanggal_mulai', Carbon::parse($this->filterDate))
                ->with(['mataPelajaran', 'kelasBimbel', 'tentor'])
                ->get();

            $pdf = PdfFacade::view('pdf.jadwal', [
                'jadwals' => $jadwals,
                'tanggal' => Carbon::parse($this->filterDate)->format('d F Y')
            ])
                ->format('a4')
                ->landscape()
                ->save('jadwal-' . Carbon::parse($this->filterDate)->format('Y-m-d') . '.pdf');

        return response()->download('jadwal-' . Carbon::parse($this->filterDate)->format('Y-m-d') . '.pdf');
    }

    public function toggleSort()
    {
        $this->sortAsc = !$this->sortAsc;
        $this->sortDirection = $this->sortAsc ? 'asc' : 'desc';
    }

    public function updatedFilterDate($value)
    {
        $this->resetPage();
    }

    public function getJadwalsProperty()
    {
        $query = JadwalBelajar::query()
            ->with(['mataPelajaran', 'tentor', 'kelasBimbel'])
            ->when($this->search, function ($query) {
                $query->where('nama_jadwal', 'like', '%' . $this->search . '%')
                    ->orWhere('hari', 'like', '%' . $this->search . '%')
                    ->orWhere('ruangan', 'like', '%' . $this->search . '%')
                    ->orWhere('kelas', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('tanggal_mulai', $this->filterDate);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $totalRecords = $query->count();
        $jadwals = $query->take($this->perPage)->get();
        $this->hasMorePages = $totalRecords > $this->perPage;

        return $jadwals;
    }

    public function render()
    {
        $jadwals = JadwalBelajar::with(['mataPelajaran', 'kelasBimbel', 'tentor'])
            ->when($this->search, function ($query) {
                $query->whereHas('mataPelajaran', function ($q) {
                    $q->where('nama_pelajaran', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('kelasBimbel', function ($q) {
                    $q->where('nama_kelas', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('tentor.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterDate, function ($query) {
                $query->whereDate('tanggal_mulai', Carbon::parse($this->filterDate));
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.jadwal.daftar-jadwal', [
            'jadwals' => $jadwals
        ]);
    }
}
