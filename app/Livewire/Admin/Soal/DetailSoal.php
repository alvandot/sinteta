<?php

namespace App\Livewire\Admin\Soal;

use App\Models\Soal\PaketSoal;
use App\Models\Soal\Soal;
use App\Models\Soal\SoalOpsi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Mary\Traits\Toast;

class DetailSoal extends Component
{
    use WithFileUploads, Toast;

    public ?PaketSoal $paketSoal = null;
    public ?Soal $soal = null;
    public $totalBobot = 0;
    public $totalSoal = 0;
    public $rataRataBobot = 0;
    public $statusPaket = '';
    public $waktuPengerjaan = 0;
    public $tingkatKesulitan = '';

    #[Rule('required|exists:soals,id')]
    public $soal_id;

    #[Rule('required|string')]
    public $pertanyaan = '';

    #[Rule('required|in:pilihan_ganda,multiple_choice,essay')]
    public $jenis_soal = '';

    #[Rule('nullable|image|max:1024')] // max 1MB
    public $gambar;

    #[Rule('required|numeric|min:0|max:100')]
    public $bobot = 0;

    public $kunci_pg = '';
    public $kunci_multiple_choice = [];
    public $kunci_essay = '';

    public $opsi = [];
    public $preview_gambar = '';

    public function mount($id)
    {
        // Cache key untuk paket soal
        $cacheKey = "paket_soal_{$id}";

        // Ambil data dari cache atau database
        $this->paketSoal = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return PaketSoal::with([
                'soals' => function ($query) {
                    $query->withCount('soalOpsi')
                          ->orderBy('nomor_urut', 'asc');
                },
                'soals.soalOpsi' => function ($query) {
                    $query->orderBy('urutan', 'asc');
                }
            ])->findOrFail($id);
        });

        // Set soal pertama dari paket
        $this->soal = $this->paketSoal->soals()->with('soalOpsi')->first();

        // Hitung statistik
        $this->calculateStatistics();
    }

    protected function calculateStatistics()
    {
        // Hitung total soal dan bobot
        $this->totalSoal = $this->paketSoal->soals->count();
        $this->totalBobot = $this->paketSoal->soals->sum('bobot');
        $this->rataRataBobot = $this->totalSoal > 0 ? $this->totalBobot / $this->totalSoal : 0;

        // Tentukan status paket berdasarkan kelengkapan
        $this->statusPaket = $this->determineStatus();

        // Set waktu pengerjaan dan tingkat kesulitan
        $this->waktuPengerjaan = $this->paketSoal->waktu_pengerjaan;
        $this->tingkatKesulitan = $this->determineDifficulty();
    }

    protected function determineStatus(): string
    {
        if ($this->totalSoal === 0) {
            return 'Draft';
        }

        $minimalBobot = $this->paketSoal->minimal_bobot ?? 100;
        if ($this->totalBobot < $minimalBobot) {
            return 'Belum Lengkap';
        }

        return 'Aktif';
    }

    protected function determineDifficulty(): string
    {
        $avgBobot = $this->rataRataBobot;

        if ($avgBobot >= 80) {
            return 'Sulit';
        } elseif ($avgBobot >= 60) {
            return 'Sedang';
        } else {
            return 'Mudah';
        }
    }

    public function edit()
    {
        $this->redirect(route('admin.soal.edit', $this->soal->id));
    }

    public function save()
    {
        $this->validate();

        try {
            if (!$this->soal) {
                $this->soal = new Soal();
            }

            $this->soal->pertanyaan = $this->pertanyaan;
            $this->soal->jenis_soal = $this->jenis_soal;
            $this->soal->bobot = $this->bobot;

            // Handle gambar
            if ($this->gambar) {
                if ($this->soal->gambar) {
                    Storage::disk('public')->delete($this->soal->gambar);
                }
                $this->soal->gambar = $this->gambar->store('soal-gambar', 'public');
            }

            // Set kunci jawaban berdasarkan jenis soal
            if ($this->jenis_soal === Soal::JENIS_PILIHAN_GANDA) {
                $this->soal->kunci_pg = $this->kunci_pg;
            } elseif ($this->jenis_soal === Soal::JENIS_MULTIPLE_CHOICE) {
                $this->soal->kunci_multiple_choice = $this->kunci_multiple_choice;
            } else {
                $this->soal->kunci_essay = $this->kunci_essay;
            }

            $this->soal->save();

            // Simpan opsi jawaban
            if (in_array($this->jenis_soal, [Soal::JENIS_PILIHAN_GANDA, Soal::JENIS_MULTIPLE_CHOICE])) {
                foreach ($this->opsi as $id => $teks) {
                    SoalOpsi::updateOrCreate(
                        ['id' => is_numeric($id) ? $id : null],
                        [
                            'soal_id' => $this->soal->id,
                            'jenis_soal' => $this->jenis_soal,
                            'teks' => $teks,
                        ]
                    );
                }
            }

            // Clear cache setelah update
            Cache::forget("paket_soal_{$this->paketSoal->id}");

            $this->success('Soal berhasil disimpan');
            $this->redirect(route('admin.soal.index'));
        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tambahOpsi()
    {
        $this->opsi[] = '';
    }

    public function hapusOpsi($index)
    {
        unset($this->opsi[$index]);
        $this->opsi = array_values($this->opsi);
    }

    public function hapusGambar()
    {
        if ($this->soal && $this->soal->gambar) {
            Storage::disk('public')->delete($this->soal->gambar);
            $this->soal->gambar = null;
            $this->soal->save();

            // Clear cache
            Cache::forget("paket_soal_{$this->paketSoal->id}");
        }
        $this->preview_gambar = '';
        $this->gambar = null;
        $this->success('Gambar berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.admin.soal.detail-soal');
    }
}
