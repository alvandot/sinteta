<?php

namespace App\Livewire\Admin\Ujian;

use App\Services\Contracts\UjianServiceInterface;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Models\Akademik\Ujian;

class DetailUjian extends Component
{
    use Toast;

    public $ujian;
    public $paketSoal;
    public array $soals = [];
    public ?int $ujianId = null;
    protected UjianServiceInterface $ujianService;

    public function boot(UjianServiceInterface $ujianService)
    {
        $this->ujianService = $ujianService;
    }

    public function mount(int $id): void
    {
        $this->ujianId = $id;
        $this->loadUjian();
    }

    private function loadUjian(): void
    {
        try {
            $ujian = Ujian::with(['paketSoal', 'mataPelajaran', 'tentor', 'daftarUjianSiswa', 'kelas'])
                ->find($this->ujianId);

            if (!$ujian) {
                $this->error('Ujian tidak ditemukan');
                return;
            }

            $this->ujian = $ujian;
            $this->loadPaketSoal();
            $this->loadSoals();
        } catch (\Exception $e) {
            $this->error('Gagal memuat data ujian: ' . $e->getMessage());
            logger()->error('DetailUjian::loadUjian error: ' . $e->getMessage());
        }
    }

    private function loadPaketSoal(): void
    {
        try {
            if ($this->ujian->paket_soal_id) {
                $this->paketSoal = $this->ujianService->getPaketSoal()
                    ->findOrFail($this->ujian->paket_soal_id);
            }
        } catch (\Exception $e) {
            $this->error('Gagal memuat paket soal: ' . $e->getMessage());
        }
    }

    private function loadSoals(): void
    {
        try {
            if ($this->ujian->paket_soal_id) {
                $paketSoal = $this->ujianService->getPaketSoal()
                    ->with('soals')
                    ->findOrFail($this->ujian->paket_soal_id);

                $this->soals = $paketSoal->soals->toArray();
            }
        } catch (\Exception $e) {
            $this->error('Gagal memuat soal: ' . $e->getMessage());
        }
    }

    public function updatePaketSoal(): void
    {
        try {
            if (!$this->paketSoal) {
                $this->error('Paket soal belum dipilih');
                return;
            }

            $this->ujianService->updateUjian($this->ujian->id, [
                'paket_soal_id' => $this->paketSoal->id
            ]);

            $this->loadSoals();
            $this->success('Paket soal berhasil diperbarui');
        } catch (\Exception $e) {
            $this->error('Gagal memperbarui paket soal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        if (!$this->ujian) {
            return view('livewire.admin.ujian.detail-ujian-not-found');
        }

        return view('livewire.admin.ujian.detail-ujian', [
            'ujian' => $this->ujian,
            'paketSoal' => $this->paketSoal,
            'soals' => $this->soals
        ]);
    }
}
