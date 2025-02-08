<?php

namespace App\Http\Livewire\Admin\Jadwal;

use App\Models\Jadwal;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\PDF;
use Livewire\Component;

class DaftarJadwal extends Component
{
    public function exportJadwalByDate()
    {
        try {
            $jadwals = $this->filterDate
                ? Jadwal::whereDate('tanggal_mulai', $this->filterDate)->get()
                : Jadwal::all();

            $pdf = PDF::loadView('pdf.jadwal', [
                'jadwals' => $jadwals,
                'tanggal' => $this->filterDate ? Carbon::parse($this->filterDate)->format('d F Y') : 'Semua Tanggal'
            ]);

            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                'jadwal-' . now()->format('Y-m-d') . '.pdf'
            );
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Gagal mengexport PDF: ' . $e->getMessage()
            ]);
        }
    }
}
