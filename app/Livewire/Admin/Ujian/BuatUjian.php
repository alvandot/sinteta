<?php

namespace App\Livewire\Admin\Ujian;

use Livewire\Component;
use App\Services\Contracts\UjianServiceInterface;
use App\Models\Soal\PaketSoal;
use Livewire\Attributes\Rule;
use Mary\Traits\Toast;

class BuatUjian extends Component
{
    use Toast;

    public bool $loading = false;

    #[Rule('required|string|max:255')]
    public string $nama = '';

    #[Rule('required|integer|exists:mata_pelajarans,id')]
    public ?int $mata_pelajaran_id = null;

    #[Rule('required|integer|exists:kelas,id')] 
    public ?int $kelas_id = null;

    #[Rule('required|date')]
    public string $waktu_mulai = '';

    #[Rule('required|date|after:waktu_mulai')]
    public string $waktu_selesai = '';

    #[Rule('required|integer|min:1')]
    public int $durasi = 0;

    #[Rule('required|integer|min:0|max:100')]
    public int $kkm = 0;

    #[Rule('required|integer|exists:paket_soals,id')]
    public ?int $paket_soal_id = null;

    #[Rule('required|string|in:soal,soal_dan_jawaban,tidak_acak')]
    public string $mode_pengacakan = '';

    #[Rule('boolean')]
    public bool $tampilkan_hasil = false;

    #[Rule('boolean')]
    public bool $tampilkan_pembahasan = false;

    #[Rule('boolean')]
    public bool $dapat_mengulang = false;

    #[Rule('boolean')]
    public bool $aktif = false;

    public array $mata_pelajaran_options = [];
    public array $kelas_options = [];
    public array $paket_soal_options = [];

    // Properti untuk modal paket soal
    public $selected_paket_soal = null;
    public $showDetailModal = false;

    // Tracking properties
    public $lastUpdatedMataPelajaranId = null;
    public $updateCount = 0;

    public function mount(UjianServiceInterface $ujianService)
    {
        \Log::info('Component mounted');
        $this->mata_pelajaran_options = $ujianService->getMataPelajaranOptions();
        $this->kelas_options = $ujianService->getKelasOptions();
        
        \Log::info('Initial mata_pelajaran_options:', $this->mata_pelajaran_options);
        $this->loadPaketSoalOptions();
    }

    public function updatedMataPelajaranId($value)
    {
        $this->updateCount++;
        $this->lastUpdatedMataPelajaranId = $value;
        
        \Log::info('updatedMataPelajaranId called', [
            'value' => $value,
            'updateCount' => $this->updateCount,
            'previous' => $this->lastUpdatedMataPelajaranId
        ]);
        
        $this->loadPaketSoalOptions();
        $this->paket_soal_id = null;
    }

    public function updatedPaketSoalId($value)
    {
        if ($value) {
            $this->selected_paket_soal = PaketSoal::with(['mataPelajaran', 'soals.soalOpsiRelation'])
                ->find($value);
            $this->showDetailModal = true;
        } else {
            $this->selected_paket_soal = null;
            $this->showDetailModal = false;
        }
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
    }

    protected function loadPaketSoalOptions()
    {
        \Log::info('loadPaketSoalOptions called', [
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'updateCount' => $this->updateCount,
            'lastUpdated' => $this->lastUpdatedMataPelajaranId
        ]);

        if ($this->mata_pelajaran_id) {
            try {
                $query = PaketSoal::where('mata_pelajaran_id', $this->mata_pelajaran_id)
                    ->with(['mataPelajaran', 'soals'])
                    ->withCount('soals');

                // Log the SQL query
                \Log::info('SQL Query: ' . $query->toSql());
                \Log::info('SQL Bindings: ', $query->getBindings());

                $paketSoal = $query->get();

                \Log::info('Raw paket soal data:', $paketSoal->toArray());

                if ($paketSoal->isEmpty()) {
                    \Log::warning('No paket soal found for mata_pelajaran_id: ' . $this->mata_pelajaran_id);
                    $this->paket_soal_options = [];
                    return;
                }

                $this->paket_soal_options = $paketSoal->map(function ($paket) {
                    $option = [
                        'id' => $paket->id,
                        'name' => $paket->nama . ' - ' . 
                                ($paket->mataPelajaran ? $paket->mataPelajaran->nama_pelajaran : 'Unknown') . 
                                ' (' . $paket->soals_count . ' soal)'
                    ];
                    \Log::info('Mapped paket soal:', $option);
                    return $option;
                })->toArray();

                \Log::info('Final paket_soal_options:', $this->paket_soal_options);

            } catch (\Exception $e) {
                \Log::error('Error in loadPaketSoalOptions: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
                $this->paket_soal_options = [];
            }
        } else {
            \Log::info('No mata_pelajaran_id selected');
            $this->paket_soal_options = [];
        }
    }

    public function save(UjianServiceInterface $ujianService)
    {
        $this->loading = true;

        try {
            $validated = $this->validate();

            // Simpan data ujian
            $ujianService->createUjian($validated);
            
            $this->success('Ujian berhasil dibuat');
            $this->dispatch('showDaftarUjian');

        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.ujian.buat-ujian');
    }
}
