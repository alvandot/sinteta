<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Absensi;

use App\Models\Akademik\Absensi;
use App\Models\Users\Siswa;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Daftar extends Component
{
    use WithPagination;
    use Toast;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function getFilteredAbsensiQuery()
    {
        return Absensi::query()
            ->with(['siswa.kelasBimbel', 'mataPelajaran'])
            ->when($this->search, function ($query) {
                $query->whereHas('siswa', function ($query) {
                    $query->where('nama_lengkap', 'like', '%' . $this->search . '%')
                        ->orWhere('nis', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('mataPelajaran', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->start_date, function ($query) {
                $query->whereDate('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->whereDate('created_at', '<=', $this->end_date);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            });
    }

    public function exportPDF()
    {
        // Validasi filter
        if (!$this->start_date || !$this->end_date) {
            $this->error('Harap pilih rentang tanggal terlebih dahulu');
            return;
        }

        // Validasi rentang tanggal
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        if ($end->diffInDays($start) > 31) {
            $this->error('Rentang tanggal maksimal 31 hari');
            return;
        }

        if ($start->isAfter($end)) {
            $this->error('Tanggal mulai harus sebelum tanggal akhir');
            return;
        }

        $absensi = $this->getFilteredAbsensiQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        if ($absensi->isEmpty()) {
            $this->error('Tidak ada data untuk diekspor');
            return;
        }

        $pdf = Pdf::loadView('pdf.absensi', [
            'absensi' => $absensi,
            'start_date' => $this->start_date ? Carbon::parse($this->start_date)->format('d M Y') : '-',
            'end_date' => $this->end_date ? Carbon::parse($this->end_date)->format('d M Y') : '-',
            'status' => $this->status ? ucfirst($this->status) : 'Semua',
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'laporan-absensi.pdf');
    }

    public function render()
    {
        $absensi = $this->getFilteredAbsensiQuery()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.absensi.daftar', [
            'absensi' => $absensi,
        ]);
    }
}
