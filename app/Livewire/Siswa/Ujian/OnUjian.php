<?php

namespace App\Livewire\Siswa\Ujian;

use App\Models\Akademik\Ujian;
use App\Models\DaftarUjianSiswa;
use App\Services\Contracts\UjianServiceInterface;
use App\Services\Contracts\SiswaServiceInterface;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\HasilUjian;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.cbtLayout')]
class OnUjian extends Component
{
    use Toast;

    public $id_ujian;
    public $soals;
    public $currentSoal = 0;
    public $total_soal;
    public $targetSoal;
    public array $flaggedSoal = [];

    public $sisa_waktu;
    public $waktu_mulai;
    public $durasi;
    public array $jawaban = [];
    public mixed $selectedJawaban = null;
    public bool $showWarningModal = false;
    public bool $showKonfirmasiModal = false;
    public float $nilai = 0;

    protected $listeners = ['selesaiUjian'];

    private UjianServiceInterface $ujianService;
    private SiswaServiceInterface $siswaService;

    public function boot(UjianServiceInterface $ujianService, SiswaServiceInterface $siswaService)
    {
        $this->ujianService = $ujianService;
        $this->siswaService = $siswaService;
    }

    public function mount(string|int $id_ujian)
    {
        $this->id_ujian = (int) $id_ujian;
        $siswa_id = auth()->guard('siswa')->id();

        if (!$siswa_id) {
            return $this->redirect(route('login.siswa'));
        }

        // Langsung query tanpa cache
        $daftarUjian = DaftarUjianSiswa::with(['ujian.paketSoal.soals'])
            ->where('id', $this->id_ujian)
            ->where('siswa_id', $siswa_id)
            ->where('status', '!=', 'selesai')
            ->first();

        if (!$daftarUjian) {
            throw new \Exception('Data ujian tidak ditemukan atau sudah selesai.');
        }

        if (!$daftarUjian->ujian || !$daftarUjian->ujian->paketSoal) {
            throw new \Exception('Data ujian atau paket soal tidak lengkap.');
        }

        $this->soals = $daftarUjian->ujian->paketSoal->soals;
        $this->total_soal = count($this->soals);

        $this->waktu_mulai = $daftarUjian->waktu_mulai ?? now();
        $this->durasi = $daftarUjian->ujian->durasi * 60;
        $this->hitungSisaWaktu();

        $this->initJawaban();
    }

    private function initJawaban(): void
    {
        foreach ($this->soals as $index => $soal) {
            $this->jawaban[$index] = $soal->jenis_soal === 'multiple_choice' ? [] : null;
        }
    }

    public function validateBeforePindah(int $targetIndex): bool
    {
        if ($this->soals[$this->currentSoal]->jenis_soal === 'multiple_choice' &&
            isset($this->jawaban[$this->currentSoal]) &&
            is_array($this->jawaban[$this->currentSoal]) &&
            count(array_filter($this->jawaban[$this->currentSoal])) === 1) {

            $this->targetSoal = $targetIndex;
            $this->showWarningModal = true;
            return false;
        }
        return true;
    }

    public function setCurrentSoal(int $index): void
    {
        if ($this->validateBeforePindah($index)) {
            $this->currentSoal = $index;
            $this->selectedJawaban = $this->jawaban[$index];
            $this->dispatch('resetRadioState');
        }
    }

    public function nextSoal(): void
    {
        $nextIndex = min($this->total_soal - 1, $this->currentSoal + 1);
        $this->setCurrentSoal($nextIndex);
    }

    public function prevSoal(): void
    {
        $prevIndex = max(0, $this->currentSoal - 1);
        $this->setCurrentSoal($prevIndex);
    }

    public function updateJawabanPG(int $index, string $value): void
    {
        try {
            if ($this->isValidIndex($index)) {
                // Langsung update tanpa cache
                $this->jawaban[$index] = $value;
                $this->selectedJawaban = $value;
                $this->dispatch('jawaban-updated');
            }
        } catch (\Exception $e) {
            Log::error('Error updating jawaban PG', ['error' => $e->getMessage(), 'index' => $index]);
            $this->showErrorToast('Gagal menyimpan jawaban');
        }
    }

    public function updateJawabanMC(int $index, string $label, bool $value): void
    {
        try {
            if ($this->isValidIndex($index)) {
                // Pastikan jawaban[$index] adalah array
                if (!isset($this->jawaban[$index])) {
                    $this->jawaban[$index] = [];
                }

                // Konversi jawaban ke format yang konsisten
                if ($value) {
                    // Tambahkan jawaban jika belum ada
                    if (!in_array($label, $this->jawaban[$index])) {
                        $this->jawaban[$index][] = $label;
                    }
                } else {
                    // Hapus jawaban yang tidak dipilih
                    $this->jawaban[$index] = array_values(array_filter(
                        $this->jawaban[$index],
                        fn($item) => $item !== $label
                    ));
                }

                // Sort array untuk konsistensi
                sort($this->jawaban[$index]);

                // Debug log
                Log::info('Jawaban MC Updated', [
                    'index' => $index,
                    'label' => $label,
                    'value' => $value,
                    'current_jawaban' => $this->jawaban[$index]
                ]);

                $this->dispatch('jawaban-updated');
            }
        } catch (\Exception $e) {
            Log::error('Error updating jawaban MC', [
                'error' => $e->getMessage(),
                'index' => $index,
                'label' => $label,
                'value' => $value
            ]);
            $this->showErrorToast('Gagal menyimpan jawaban');
        }
    }

    public function updateJawabanEssay(int $index, string $value): void
    {
        try {
            if ($this->isValidIndex($index)) {
                // Langsung update tanpa cache
                $this->jawaban[$index] = $value;
                $this->dispatch('jawaban-updated');
            }
        } catch (\Exception $e) {
            Log::error('Error updating jawaban Essay', ['error' => $e->getMessage(), 'index' => $index]);
            $this->showErrorToast('Gagal menyimpan jawaban');
        }
    }

    private function isValidIndex(int $index): bool
    {
        return $index >= 0 && $index < $this->total_soal;
    }

    private function showErrorToast(string $message): void
    {
        $this->toast(
            type: 'error',
            title: 'Error',
            description: $message,
            position: 'top-right'
        );
    }

    public function hitungSisaWaktu(): void
    {
        $waktuSelesai = Carbon::parse($this->waktu_mulai)->addSeconds($this->durasi);
        $this->sisa_waktu = now()->diffInSeconds($waktuSelesai, false);

        if ($this->sisa_waktu <= 0) {
            $this->selesaiUjian();
        }
    }

    public function hitungNilai(): float
    {
        try {
            return $this->ujianService->hitungNilai($this->soals, $this->jawaban);
        } catch (\Exception $e) {
            Log::error('Error dalam perhitungan nilai', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function selesaiUjian()
    {
        $this->showKonfirmasiModal = false;
        $nilai = $this->hitungNilai();

        // Update status ujian
        $daftarUjian = DaftarUjianSiswa::where('id', $this->id_ujian)
            ->where('siswa_id', auth()->guard('siswa')->id())
            ->first();

        if (!$daftarUjian) {
            throw new \Exception('Data ujian tidak ditemukan.');
        }

        // Update status daftar ujian menjadi selesai
        $daftarUjian->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        // Hitung total jawaban benar dan salah
        $totalBenar = 0;
        $totalSalah = 0;
        $totalTidakDijawab = 0;

        foreach ($this->soals as $index => $soal) {
            $jawabanSiswa = $this->jawaban[$index] ?? null;
            $isCorrect = $this->checkJawabanBenar($jawabanSiswa, $soal);

            if ($jawabanSiswa === null || $jawabanSiswa === '') {
                $totalTidakDijawab++;
            } elseif ($isCorrect) {
                $totalBenar++;
            } else {
                $totalSalah++;
            }
        }

        // Simpan hasil ujian dengan menambahkan paket_soal_id
        HasilUjian::create([
            'ujian_id' => $this->id_ujian,
            'siswa_id' => auth()->guard('siswa')->id(),
            'paket_soal_id' => $daftarUjian->ujian->paket_soal_id,
            'nilai_akhir' => $nilai,
            'total_jawaban_benar' => $totalBenar,
            'total_jawaban_salah' => $totalSalah,
            'total_tidak_dijawab' => $totalTidakDijawab,
            'detail_penilaian' => $this->formatDetailPenilaian(),
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => now(),
            'durasi_pengerjaan' => now()->diffInSeconds($this->waktu_mulai)
        ]);

        // Generate PDF menggunakan Spatie PDF
        $data = $this->preparePDFData($daftarUjian, $nilai);
        $filename = $this->generatePDFFilename($daftarUjian);

        try {
            // Buat PDF dengan Spatie
            $pdfPath = storage_path('app/public/hasil-ujian/' . $filename);

            Pdf::view('pdfs.hasil-ujian', $data)
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->save($pdfPath);

            $this->toast(
                type: 'success',
                title: 'Ujian berhasil diselesaikan',
                description: 'Hasil ujian akan didownload otomatis',
                position: 'top-right'
            );

            // Dispatch event untuk trigger download dan redirect
            $this->dispatch('downloadAndRedirect', [
                'downloadUrl' => route('siswa.download.hasil-ujian', [
                    'filename' => $filename,
                    'ts' => time(),
                    'inline' => true
                ]),
                'redirectUrl' => route('siswa.ujian.riwayat', [
                    'status' => 'success',
                    'message' => 'Ujian berhasil diselesaikan'
                ])
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());

            $this->toast(
                type: 'error',
                title: 'Terjadi kesalahan',
                description: 'Gagal membuat file PDF hasil ujian',
                position: 'top-right'
            );

            return redirect()->route('siswa.ujian.riwayat', [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat PDF'
            ]);
        }
    }

    private function formatDetailPenilaian(): array
    {
        $detailPenilaian = [];
        foreach ($this->soals as $index => $soal) {
            $jawabanSiswa = $this->jawaban[$index] ?? null;
            $isCorrect = $this->checkJawabanBenar($jawabanSiswa, $soal);

            $detailPenilaian[] = [
                'nomor_soal' => $index + 1,
                'jenis_soal' => $soal->jenis_soal,
                'jawaban_siswa' => $jawabanSiswa,
                'is_correct' => $isCorrect,
                'bobot' => $soal->bobot ?? 1
            ];
        }
        return $detailPenilaian;
    }

    private function generateAndDownloadPDF(DaftarUjianSiswa $daftarUjian, float $nilai)
    {
        $data = $this->preparePDFData($daftarUjian, $nilai);
        $filename = $this->generatePDFFilename($daftarUjian);

        $this->toast(
            type: 'success',
            title: 'Ujian berhasil diselesaikan',
            description: 'Hasil ujian akan didownload otomatis',
            position: 'top-right'
        );

        return response()->streamDownload(function() use ($data) {
            echo Pdf::view('pdf.hasil-ujian', $data)
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->showInfo(false)
                ->download();
        }, $filename);
    }

    private function preparePDFData(DaftarUjianSiswa $daftarUjian, float $nilai): array
    {
        $hasil_ujian = HasilUjian::where('ujian_id', $this->id_ujian)
            ->where('siswa_id', auth()->guard('siswa')->user()->id)
            ->latest()
            ->first();

        $jawaban_formatted = [];
        foreach ($this->soals as $index => $soal) {
            $jawaban_siswa = $this->jawaban[$index] ?? null;
            $is_correct = $this->checkJawabanBenar($jawaban_siswa, $soal);

            $jawaban_formatted[] = [
                'nomor' => $index + 1,
                'pertanyaan' => $soal->pertanyaan,
                'jenis_soal' => $soal->jenis_soal,
                'jawaban_siswa' => $this->formatJawaban($jawaban_siswa, $soal->jenis_soal),
                'kunci_jawaban' => $this->formatKunciJawaban($soal),
                'is_correct' => $is_correct,
                'bobot' => $soal->bobot ?? 1
            ];
        }

        return [
            'id_ujian' => $daftarUjian->id,
            'nama_siswa' => $daftarUjian->siswa->nama_lengkap,
            'kelas_siswa' => $daftarUjian->siswa->kelasBimbel->nama_kelas ?? '-',
            'nama_ujian' => $daftarUjian->ujian->nama,
            'tanggal' => Carbon::now()->format('d F Y'),
            'waktu_mulai' => Carbon::parse($daftarUjian->waktu_mulai)->format('H:i'),
            'waktu_selesai' => Carbon::parse($daftarUjian->waktu_selesai)->format('H:i'),
            'durasi' => $hasil_ujian ? $hasil_ujian->getDurasiFormatted() : '-',
            'nilai' => $nilai,
            'jawaban' => $jawaban_formatted,
            'total_soal' => $this->total_soal,
            'total_jawaban' => count($this->getJawabanTerjawab()),
            'total_benar' => count(array_filter($jawaban_formatted, fn($j) => $j['is_correct'] === true)),
            'total_salah' => count(array_filter($jawaban_formatted, fn($j) => $j['is_correct'] === false)),
            'total_belum_dinilai' => count(array_filter($jawaban_formatted, fn($j) => $j['is_correct'] === null)),
            // Data Tambahan
            'statistik_kategori' => $hasil_ujian ? $hasil_ujian->getStatistikKategori() : [],
            'soal_sulit' => $hasil_ujian ? $hasil_ujian->getSoalSulit() : [],
            'rekomendasi' => $hasil_ujian ? $hasil_ujian->getRekomendasi() : []
        ];
    }

    private function formatJawabanForPDF(): array
    {
        $formatted = [];
        foreach ($this->soals as $index => $soal) {
            $formatted[] = [
                'nomor' => $index + 1,
                'pertanyaan' => $soal->pertanyaan,
                'jenis_soal' => $soal->jenis_soal,
                'jawaban_siswa' => $this->formatJawaban($this->jawaban[$index] ?? null, $soal->jenis_soal, $soal),
                'kunci_jawaban' => $this->formatKunciJawaban($soal),
                'is_correct' => $this->checkJawabanBenar($this->jawaban[$index] ?? null, $soal)
            ];
        }
        return $formatted;
    }

    private function generatePDFFilename(DaftarUjianSiswa $daftarUjian): string
    {
        return sprintf(
            'hasil_ujian_%s_%s.pdf',
            Str::slug($daftarUjian->siswa->nama_lengkap),
            now()->format('Y-m-d_H-i')
        );
    }

    public function getJawabanTerjawab(): array
    {
        return array_filter($this->jawaban, function($jawaban) {
            if (is_array($jawaban)) {
                return !empty(array_filter($jawaban));
            }
            return !empty($jawaban) && $jawaban !== '';
        });
    }

    public function render()
    {
        // Hapus penggunaan Cache
        return view('livewire.siswa.ujian.on-ujian', [
            'soal' => $this->soals[$this->currentSoal] ?? null,
            'total_soal' => $this->total_soal,
            'ujian' => Ujian::find($this->id_ujian), // Langsung query tanpa cache
            'jumlah_terjawab' => count($this->getJawabanTerjawab())
        ]);
    }

    private function formatJawaban($jawaban, $jenis_soal, $soal = null)
    {
        if (is_null($jawaban)) {
            return 'Tidak dijawab';
        }

        switch ($jenis_soal) {
            case 'pilihan_ganda':
            case 'pg':
                return $jawaban;

            case 'multiple_choice':
            case 'mc':
                if (is_array($jawaban)) {
                    // Jika array kosong, berarti tidak dijawab
                    if (empty($jawaban)) {
                        return 'Tidak dijawab';
                    }

                    // Konversi jawaban ke format huruf dan urutkan
                    $formatted = array_map(function($item) {
                        // Jika item sudah berupa huruf (A, B, C, dst)
                        if (preg_match('/^[A-Z]$/', $item)) {
                            return $item;
                        }
                        // Jika item berupa angka, konversi ke huruf (0->A, 1->B, dst)
                        return chr(65 + intval($item));
                    }, $jawaban);

                    sort($formatted);
                    return implode(', ', $formatted);
                }
                return 'Format tidak valid';

            case 'essay':
                return $jawaban;

            default:
                return 'Format tidak dikenali';
        }
    }

    private function checkJawabanBenar($jawaban_siswa, $soal)
    {
        if ($jawaban_siswa === null) return false;

        switch ($soal->jenis_soal) {
            case 'pilihan_ganda':
                return $jawaban_siswa === $soal->kunci_pg;

            case 'multiple_choice':
                // Debug log untuk melihat input
                Log::info('Input Multiple Choice', [
                    'soal_id' => $soal->id,
                    'jawaban_siswa' => $jawaban_siswa,
                    'kunci_jawaban' => $soal->kunci_multiple_choice
                ]);

                // Jika jawaban siswa kosong, langsung return false
                if (empty($jawaban_siswa)) {
                    Log::info('Jawaban siswa kosong');
                    return false;
                }

                // Normalisasi jawaban siswa
                if (is_array($jawaban_siswa)) {
                    // Jika jawaban dalam format array biasa
                    $normalizedJawaban = array_map('strtoupper', $jawaban_siswa);
                } else {
                    Log::error('Format jawaban siswa tidak valid', ['jawaban' => $jawaban_siswa]);
                    return false;
                }

                // Normalisasi kunci jawaban
                $kunciJawaban = $soal->kunci_multiple_choice;
                if (is_array($kunciJawaban)) {
                    $normalizedKunci = array_map('strtoupper', $kunciJawaban);
                } else if (is_string($kunciJawaban)) {
                    $decoded = json_decode($kunciJawaban, true);
                    if (is_array($decoded)) {
                        $normalizedKunci = array_map('strtoupper', $decoded);
                    } else {
                        $normalizedKunci = array_map('trim', array_map('strtoupper', explode(',', $kunciJawaban)));
                    }
                } else {
                    Log::error('Format kunci jawaban tidak valid', ['kunci' => $kunciJawaban]);
                    return false;
                }

                // Sort arrays untuk konsistensi
                sort($normalizedKunci);
                sort($normalizedJawaban);

                // Debug log untuk melihat hasil normalisasi
                Log::info('Normalized Multiple Choice', [
                    'soal_id' => $soal->id,
                    'kunci_jawaban_raw' => $kunciJawaban,
                    'normalized_kunci' => $normalizedKunci,
                    'jawaban_siswa_raw' => $jawaban_siswa,
                    'normalized_jawaban' => $normalizedJawaban,
                    'is_equal' => $normalizedKunci == $normalizedJawaban
                ]);

                // Bandingkan array yang sudah dinormalisasi
                return $normalizedKunci == $normalizedJawaban;

            case 'essay':
                return null;

            default:
                return false;
        }
    }

    private function formatKunciJawaban($soal)
    {
        if ($soal->jenis_soal === 'pilihan_ganda' || $soal->jenis_soal === 'pg') {
            return $soal->kunci_pg;
        } elseif ($soal->jenis_soal === 'multiple_choice' || $soal->jenis_soal === 'mc') {
            $kunci_jawaban = $soal->kunci_multiple_choice;

            // Handle berbagai format kunci jawaban
            if (is_array($kunci_jawaban)) {
                $kunci_array = $kunci_jawaban;
            } else if (is_string($kunci_jawaban)) {
                $decoded = json_decode($kunci_jawaban, true);
                if (is_array($decoded)) {
                    if (array_is_list($decoded)) {
                        $kunci_array = $decoded;
                    } else {
                        $kunci_array = array_keys(array_filter($decoded));
                    }
                } else {
                    $kunci_array = array_map('trim', explode(',', $kunci_jawaban));
                }
            } else {
                return 'Format tidak valid';
            }

            // Konversi ke format huruf jika perlu
            $formatted = array_map(function($item) {
                // Jika item sudah berupa huruf (A, B, C, dst)
                if (preg_match('/^[A-Z]$/', $item)) {
                    return $item;
                }
                // Jika item berupa angka, konversi ke huruf (0->A, 1->B, dst)
                return chr(65 + intval($item));
            }, $kunci_array);

            // Sort array untuk konsistensi
            sort($formatted);

            // Log untuk debugging
            Log::info('Format Kunci Jawaban', [
                'soal_id' => $soal->id,
                'kunci_raw' => $kunci_jawaban,
                'kunci_processed' => $formatted,
                'result' => implode(', ', $formatted)
            ]);

            return implode(', ', $formatted);
        } elseif ($soal->jenis_soal === 'essay') {
            return $soal->kunci_essay ?? 'Tidak ada kunci jawaban';
        }
        return 'Format tidak dikenali';
    }

    public function toggleFlag(int $index): void
    {
        if ($this->isValidIndex($index)) {
            if (isset($this->flaggedSoal[$index]) && $this->flaggedSoal[$index]) {
                unset($this->flaggedSoal[$index]);
            } else {
                $this->flaggedSoal[$index] = true;
            }
        }
    }

    private function getSoalCategories(): array
    {
        $categories = [];
        foreach ($this->soals as $soal) {
            $type = $soal->jenis_soal;
            if (!isset($categories[$type])) {
                $categories[$type] = 0;
            }
            $categories[$type]++;
        }
        return $categories;
    }

    private function getUrutanPengerjaan(): array
    {
        $urutan = [];
        foreach ($this->jawaban as $index => $jawaban) {
            if (!empty($jawaban)) {
                $urutan[] = $index + 1;
            }
        }
        return $urutan;
    }

    private function getWaktuPerSoal(): array
    {
        // Implementasi sederhana, bisa dikembangkan untuk tracking waktu per soal yang lebih akurat
        $totalWaktu = now()->diffInSeconds($this->waktu_mulai);
        $totalSoal = count(array_filter($this->jawaban, fn($j) => !empty($j)));

        return [
            'rata_rata_per_soal' => $totalSoal > 0 ? round($totalWaktu / $totalSoal) : 0,
            'total_waktu' => $totalWaktu
        ];
    }

    private function generateCatatanKhusus(int $totalBenar, int $totalSalah, int $totalTidakDijawab, float $nilai): string
    {
        $catatan = [];

        // Analisis performa
        if ($nilai >= 90) {
            $catatan[] = "Performa sangat baik dengan nilai {$nilai}";
        } elseif ($nilai >= 75) {
            $catatan[] = "Performa cukup baik dengan nilai {$nilai}";
        } else {
            $catatan[] = "Perlu peningkatan, nilai: {$nilai}";
        }

        // Analisis pengerjaan
        $totalSoal = $totalBenar + $totalSalah + $totalTidakDijawab;
        $persenTerjawab = round((($totalBenar + $totalSalah) / $totalSoal) * 100);

        if ($totalTidakDijawab > 0) {
            $catatan[] = "Terdapat {$totalTidakDijawab} soal yang tidak dijawab";
        }

        if ($persenTerjawab == 100) {
            $catatan[] = "Semua soal dijawab dengan baik";
        }

        // Analisis waktu
        $durasiPengerjaan = now()->diffInMinutes($this->waktu_mulai);
        $durasiUjian = $this->durasi / 60; // konversi ke menit

        if ($durasiPengerjaan <= $durasiUjian * 0.5) {
            $catatan[] = "Pengerjaan sangat cepat, selesai dalam {$durasiPengerjaan} menit";
        } elseif ($durasiPengerjaan >= $durasiUjian * 0.9) {
            $catatan[] = "Pengerjaan mendekati batas waktu";
        }

        return implode(". ", $catatan) . ".";
    }

    public function isSoalTerjawab(int $index): bool
    {
        if (!isset($this->jawaban[$index])) {
            return false;
        }

        $jawaban = $this->jawaban[$index];

        // Untuk multiple choice
        if (is_array($jawaban)) {
            return !empty(array_filter($jawaban));
        }

        // Untuk tipe jawaban lain
        return !empty($jawaban) && $jawaban !== '';
    }
}



