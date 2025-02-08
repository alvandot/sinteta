<?php

namespace App\Livewire\Siswa\Ujian;

use App\Models\HasilUjian;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.siswaLayout')]
class RiwayatHasilUjian extends Component
{
    use WithPagination, Toast;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedHasil = null;
    public $showDetailModal = false;

    public function mount()
    {
        if (!auth()->guard('siswa')->check()) {
            return redirect()->route('login.siswa');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function showDetail($hasilId)
    {
        try {
            $this->selectedHasil = HasilUjian::with([
                'ujian.paketSoal.soals',
                'daftarUjianSiswa.mataPelajaran',
                'daftarUjianSiswa.ujian',
                'siswa.kelasBimbel'
            ])
            ->where('ujian_id', $hasilId)
            ->where('siswa_id', auth()->guard('siswa')->id())
            ->first();

            if (!$this->selectedHasil) {
                $this->error('Hasil ujian tidak ditemukan');
                return;
            }

            // Gunakan nilai yang sudah tersimpan di database
            $totalBenar = $this->selectedHasil->total_jawaban_benar ?? 0;
            $totalSalah = $this->selectedHasil->total_jawaban_salah ?? 0;
            $totalTidakDijawab = $this->selectedHasil->total_tidak_dijawab ?? 0;
            $nilaiAkhir = $this->selectedHasil->nilai_akhir ?? 0;

            // Format detail jawaban untuk ditampilkan
            if ($this->selectedHasil->detail_penilaian && is_array($this->selectedHasil->detail_penilaian)) {
                if ($this->selectedHasil->ujian && $this->selectedHasil->ujian->paketSoal && $this->selectedHasil->ujian->paketSoal->soals) {
                    $soals = $this->selectedHasil->ujian->paketSoal->soals;

                    $this->selectedHasil->detail_jawaban = collect($this->selectedHasil->detail_penilaian)
                        ->map(function ($item) use ($soals) {
                            if (!isset($item['nomor_soal'])) {
                                \Log::warning('Nomor soal tidak ditemukan dalam detail penilaian', ['item' => $item]);
                                return null;
                            }

                            // Cari soal berdasarkan nomor urut
                            $soal = $soals->firstWhere('nomor_urut', $item['nomor_soal']);

                            if (!$soal) {
                                \Log::warning('Soal tidak ditemukan', ['nomor_soal' => $item['nomor_soal']]);
                                return null;
                            }

                            return [
                                'nomor_soal' => $item['nomor_soal'],
                                'pertanyaan' => $soal->pertanyaan,
                                'pilihan' => $soal->pilihan_jawaban,
                                'jawaban_siswa' => $item['jawaban_siswa'] ?? 'Tidak dijawab',
                                'jawaban_benar' => $this->getKunciJawaban($soal),
                                'is_correct' => $item['is_correct'] ?? false,
                                'pembahasan' => $soal->pembahasan,
                                'jenis_soal' => $soal->jenis_soal,
                                'bobot' => $item['bobot'] ?? $soal->bobot ?? 1,
                                'nilai_soal' => ($item['is_correct'] ?? false) ? ($item['bobot'] ?? $soal->bobot ?? 1) : 0
                            ];
                        })
                        ->filter()
                        ->values()
                        ->toArray();
                }
            }

            // Log data untuk debugging
            \Log::info('Data Modal Detail:', [
                'hasil_id' => $this->selectedHasil->id,
                'total_soal' => count($this->selectedHasil->detail_penilaian ?? []),
                'total_benar' => $totalBenar,
                'total_salah' => $totalSalah,
                'total_tidak_dijawab' => $totalTidakDijawab,
                'nilai_akhir' => $nilaiAkhir,
                'detail_jawaban_count' => count($this->selectedHasil->detail_jawaban ?? [])
            ]);

            $this->showDetailModal = true;

        } catch (\Exception $e) {
            \Log::error('Error showing detail:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Terjadi kesalahan saat menampilkan detail: ' . $e->getMessage());
        }
    }

    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedHasil = null;
    }

    public function downloadHasilUjian($ujianId)
    {
        try {
            $hasil = HasilUjian::with([
                'siswa',
                'ujian.paketSoal.soals',
                'daftarUjianSiswa.mataPelajaran'
            ])->where('ujian_id', $ujianId)
              ->first();

            if (!$hasil) {
                $this->error('Data hasil ujian tidak ditemukan');
                return;
            }

            $daftarUjian = $hasil->daftarUjianSiswa;

            if (!$daftarUjian) {
                $this->error('Data ujian tidak ditemukan');
                return;
            }

            // Hitung ulang total jawaban dan nilai
            $totalBenar = 0;
            $totalSalah = 0;
            $totalBobot = 0;
            $nilaiAkhir = 0;

            if ($hasil->detail_penilaian && is_array($hasil->detail_penilaian)) {
                foreach ($hasil->detail_penilaian as $detail) {
                    if ($detail['is_correct'] ?? false) {
                        $totalBenar++;
                        $nilaiAkhir += $detail['bobot'] ?? 0;
                    } else {
                        $totalSalah++;
                    }
                    $totalBobot += $detail['bobot'] ?? 0;
                }
            }

            // Normalisasi nilai ke skala 100
            $nilaiAkhir = $totalBobot > 0 ? ($nilaiAkhir / $totalBobot) * 100 : 0;

            $data = [
                'id_ujian' => $hasil->id,
                'nama_siswa' => $hasil->siswa->nama_lengkap ?? '-',
                'kelas_siswa' => $hasil->siswa->kelasBimbel->nama_kelas ?? '-',
                'nama_ujian' => $daftarUjian->ujian->nama ?? '-',
                'mata_pelajaran' => $daftarUjian->mataPelajaran->nama ?? '-',
                'tanggal' => $hasil->created_at->format('d F Y'),
                'waktu_mulai' => $hasil->waktu_mulai?->format('H:i') ?? '-',
                'waktu_selesai' => $hasil->waktu_selesai?->format('H:i') ?? '-',
                'durasi' => $hasil->getDurasiFormatted() ?? '-',
                'nilai' => number_format($nilaiAkhir, 2),
                'total_soal' => $totalBenar + $totalSalah,
                'total_benar' => $totalBenar,
                'total_salah' => $totalSalah,
                'total_tidak_dijawab' => 0,
                'total_jawaban' => $totalBenar + $totalSalah,
                'detail_penilaian' => $hasil->detail_penilaian ?? [],
                'statistik_kategori' => $hasil->getStatistikKategori() ?? [],
                'soal_sulit' => $hasil->getSoalSulit() ?? [],
                'rekomendasi' => $hasil->getRekomendasi() ?? [],
                'jawaban' => []
            ];

            // Format jawaban dengan pengecekan yang lebih ketat
            if ($hasil->detail_penilaian && is_array($hasil->detail_penilaian)) {
                $soals = $hasil->ujian->paketSoal->soals;

                $data['jawaban'] = collect($hasil->detail_penilaian)
                    ->map(function ($item) use ($soals) {
                        // Pastikan nomor_soal ada dalam item
                        if (!isset($item['nomor_soal'])) {
                            \Log::warning('Nomor soal tidak ditemukan dalam detail penilaian', ['item' => $item]);
                            return null;
                        }

                        // Cari soal berdasarkan nomor urut
                        $soal = $soals->where('nomor_urut', $item['nomor_soal'])->first();

                        if (!$soal) {
                            \Log::warning('Soal tidak ditemukan', ['nomor_soal' => $item['nomor_soal']]);
                            return null;
                        }

                        // Pastikan bobot soal sesuai
                        $bobot = $soal->bobot ?? 1;
                        $nilaiSoal = $item['is_correct'] ? $bobot : 0;

                        return [
                            'nomor' => $item['nomor_soal'],
                            'pertanyaan' => $soal->pertanyaan,
                            'pilihan' => $soal->pilihan_jawaban,
                            'jawaban_siswa' => $item['jawaban_siswa'] ?? 'Tidak dijawab',
                            'kunci_jawaban' => $this->getKunciJawaban($soal),
                            'is_correct' => $item['is_correct'] ?? false,
                            'pembahasan' => $soal->pembahasan,
                            'jenis_soal' => $soal->jenis_soal,
                            'bobot' => $bobot,
                            'nilai_soal' => $nilaiSoal
                        ];
                    })
                    ->filter()
                    ->values()
                    ->toArray();
            }

            // Log data sebelum generate PDF untuk debugging
            \Log::info('Data untuk PDF:', [
                'total_soal' => $data['total_soal'],
                'total_jawaban' => count($data['jawaban']),
                'nilai' => $data['nilai'],
                'total_benar' => $data['total_benar'],
                'total_salah' => $data['total_salah'],
                'total_bobot' => $totalBobot,
                'nilai_akhir' => $nilaiAkhir
            ]);

            $pdf = Pdf::loadView('pdf.hasil-ujian', $data);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'hasil-ujian-' . $hasil->id . '.pdf'
            );

        } catch (\Exception $e) {
            \Log::error('Error downloading hasil ujian:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Terjadi kesalahan saat mengunduh hasil ujian: ' . $e->getMessage());
            return;
        }
    }

    public function getHasilUjianQuery()
    {
        $siswaId = auth()->guard('siswa')->id();

        return HasilUjian::with([
                'daftarUjianSiswa.ujian',
                'daftarUjianSiswa.mataPelajaran',
                'siswa'
            ])
            ->where('siswa_id', $siswaId)
            ->when($this->search, function($query) {
                $query->whereHas('daftarUjianSiswa.ujian', function($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                })->orWhereHas('daftarUjianSiswa.mataPelajaran', function($q) {
                    $q->where('nama_pelajaran', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    private function getKunciJawaban($soal)
    {
        if (!$soal) return '-';

        switch ($soal->jenis_soal) {
            case 'pilihan_ganda':
                return $soal->kunci_pg ?? '-';
            case 'multiple_choice':
                if (is_array($soal->kunci_multiple_choice)) {
                    return implode(', ', $soal->kunci_multiple_choice);
                }
                return $soal->kunci_multiple_choice ?? '-';
            case 'essay':
                return $soal->kunci_essay ?? '-';
            default:
                return '-';
        }
    }

    public function render()
    {
        return view('livewire.siswa.ujian.riwayat-hasil-ujian', [
            'hasilUjians' => $this->getHasilUjianQuery()->paginate($this->perPage)
        ]);
    }
}
