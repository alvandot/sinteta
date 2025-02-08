<?php

namespace App\Livewire\Admin\Soal;

use App\Models\Akademik\MataPelajaran;
use App\Models\Soal\PaketSoal;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Spatie\LaravelPdf\Facades\Pdf;

#[Layout('components.layouts.app')]
class DaftarSoal extends Component
{
    use WithPagination, Toast, WithFileUploads;

    public $search = '';
    public $mata_pelajaran_id = '';
    public $tingkat = '';
    public $tahun = '';
    public $selectedPaketSoal = null;
    public $showDeleteModal = false;
    public $perPage = 9;
    public $showPreviewModal = false;
    public $selectedPaket = null;
    public $showImportModal = false;
    public $importFile = null;
    public $importMataPelajaranId = '';
    public $importTingkat = '';
    public $importTahun = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'mata_pelajaran_id' => ['except' => ''],
        'tingkat' => ['except' => ''],
        'tahun' => ['except' => ''],
    ];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedMataPelajaranId()
    {
        $this->resetPage();
    }

    public function updatedTingkat()
    {
        $this->resetPage();
    }

    public function updatedTahun()
    {
        $this->resetPage();
    }

    public function deletePaketSoal($id)
    {
        try {
            $paketSoal = PaketSoal::findOrFail($id);
            $paketSoal->delete();

            $this->success('Paket soal berhasil dihapus');
        } catch (\Exception $e) {
            $this->error('Gagal menghapus paket soal');
        }

        $this->showDeleteModal = false;
    }

    public function getTingkatOptionsProperty()
    {
        return [
            ['label' => 'SD', 'value' => 'SD'],
            ['label' => 'SMP', 'value' => 'SMP'],
            ['label' => 'SMA', 'value' => 'SMA'],
        ];
    }

    public function getTahunOptionsProperty()
    {
        $currentYear = date('Y');
        $years = [];
        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $years[] = [
                'label' => $year,
                'value' => $year,
            ];
        }
        return $years;
    }

    public function loadMore()
    {
        $this->perPage += 9;
    }


    public function export($id = null)
    {
        try {
            $filename = 'paket-soal-' . now()->format('Y-m-d-His') . '.pdf';
            return Pdf::download(new SoalExport($id), $filename);
        } catch (\Exception $e) {
            $this->error('Gagal mengexport: ' . $e->getMessage());
        }
    }

    public function showImport()
    {
        $this->showImportModal = true;
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls',
            'importMataPelajaranId' => 'required',
            'importTingkat' => 'required',
            'importTahun' => 'required',
        ]);

        try {
            Excel::import(
                new SoalImport(
                    $this->importMataPelajaranId,
                    $this->importTingkat,
                    $this->importTahun
                ),
                $this->importFile
            );

            $this->success('Import berhasil');
            $this->showImportModal = false;
            $this->reset(['importFile', 'importMataPelajaranId', 'importTingkat', 'importTahun']);
        } catch (\Exception $e) {
            $this->error('Gagal mengimport: ' . $e->getMessage());
        }
    }

    public function exportPDF($id)
    {
            $paketSoal = PaketSoal::with([
                'mataPelajaran',
                'soals',
                'soals.soalOpsiRelation'
            ])->findOrFail($id);

            Pdf::view('pdfs.paket-soal', [
                'paketSoal' => $paketSoal
            ])
            ->format('a4')
            ->margins(15, 15, 15, 15)
            ->save('paket-soal.pdf');

            return response()->download('paket-soal.pdf');
    }

    public function previewSoal($id)
    {
        try {
            $this->selectedPaket = PaketSoal::with([
                'mataPelajaran',
                'soals' => function ($query) {
                    $query->orderBy('nomor_urut');
                },
                'soals.opsiJawabanPG',
                'soals.opsiJawabanMultipleChoice',
                'soals.soalOpsiRelation'
            ])->findOrFail($id);

            if (!$this->selectedPaket) {
                throw new \Exception('Paket soal tidak ditemukan');
            }

            $this->showPreviewModal = true;
        } catch (\Exception $e) {
            $this->error('Gagal memuat preview soal: ' . $e->getMessage());
        }
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal = false;
        $this->selectedPaket = null;
    }

    public function render()
    {
        $query = PaketSoal::with('mataPelajaran')
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->when($this->mata_pelajaran_id, function ($query) {
                $query->where('mata_pelajaran_id', $this->mata_pelajaran_id);
            })
            ->when($this->tingkat, function ($query) {
                $query->where('tingkat', $this->tingkat);
            })
            ->when($this->tahun, function ($query) {
                $query->where('tahun', $this->tahun);
            })
            ->withCount('soals')
            ->latest();

        $paketSoals = $query->paginate($this->perPage);
        $mataPelajarans = MataPelajaran::all();

        return view('livewire.admin.soal.daftar-soal', [
            'paketSoals' => $paketSoals,
            'mataPelajarans' => $mataPelajarans,
        ]);
    }
}
