<?php

namespace App\Livewire\Admin\Ujian;

use App\Models\Akademik\Ujian;
use App\Models\DaftarUjianSiswa;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Livewire\Attributes\Layout;
use Spatie\LaravelPdf\Facades\Pdf;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class DaftarUjian extends Component
{
    use WithPagination, Toast;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filters = [
        'status' => '',
    ];

    public bool $showPreview = false;
    public $selectedUjian = null;

    // Tambahkan properti untuk filter tanggal
    public $tanggalMulai;
    public $tanggalAkhir;

    public bool $showExportFilter = false;

    protected $listeners = ['closeModal' => 'closePreview'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(Ujian $ujian)
    {
        try {
            $ujian->delete();
            $this->success('Ujian berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus ujian');
        }
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->selectedUjian = null;
    }

    public function preview($ujianId)
    {
        $this->selectedUjian = Ujian::with([
            'paketSoal.soals' => function($query) {
                $query->select(['id', 'paket_soal_id', 'pertanyaan', 'jenis_soal','kunci_essay'])
                    ->with(['opsiJawabanPG' => function($q) {
                        $q->orderBy('urutan');
                    },
                    'opsiJawabanMultipleChoice' => function($q) {
                        $q->orderBy('urutan');
                    },
                    'opsiJawabanEssay' => function($q) {
                        $q->orderBy('urutan');
                    }
                ]);
            },
            'daftarUjianSiswa.mataPelajaran',
            'daftarUjianSiswa.tentor.user'
        ])->findOrFail($ujianId);
        $this->showPreview = true;
    }

    public function exportPDF()
    {
        $this->validate([
            'tanggalMulai' => 'required|date',
            'tanggalAkhir' => 'required|date|after_or_equal:tanggalMulai',
        ], [
            'tanggalMulai.required' => 'Tanggal mulai harus diisi',
            'tanggalAkhir.required' => 'Tanggal akhir harus diisi',
            'tanggalAkhir.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai',
        ]);

        $ujians = Ujian::query()
            ->whereBetween('waktu_mulai', [
                Carbon::parse($this->tanggalMulai)->startOfDay(),
                Carbon::parse($this->tanggalAkhir)->endOfDay()
            ])
            ->with(['daftarUjianSiswa.mataPelajaran', 'daftarUjianSiswa.tentor.user'])
            ->get();

        if ($ujians->isEmpty()) {
            $this->error('Tidak ada data ujian pada periode yang dipilih');
            return;
        }

        $pdf = Pdf::view('pdf.daftar-ujian', [
            'ujians' => $ujians,
            'tanggalMulai' => Carbon::parse($this->tanggalMulai)->format('d M Y'),
            'tanggalAkhir' => Carbon::parse($this->tanggalAkhir)->format('d M Y'),
            'tanggal' => now(),
        ])->format('a4')->save('daftar-ujian.pdf');

        return response()->download('daftar-ujian.pdf');
    }

    public function toggleExportFilter()
    {
        $this->showExportFilter = !$this->showExportFilter;
        if (!$this->showExportFilter) {
            $this->tanggalMulai = null;
            $this->tanggalAkhir = null;
        }
    }

    public function render()
    {
        $ujians = Ujian::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with(['paketSoal', 'daftarUjianSiswa' => function($query) {
                $query->with(['mataPelajaran', 'tentor.user']);
            }])
            ->paginate($this->perPage);

        return view('livewire.admin.ujian.daftar-ujian', [
            'ujians' => $ujians
        ]);
    }
}
