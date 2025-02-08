<?php

namespace App\Livewire\Tentor\Absensi;

use App\Models\Akademik\Absensi;
use App\Models\Akademik\JadwalBelajar;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

#[Layout('components.layouts.tentorLayout')]
class DaftarAbsensi extends Component
{
    use WithPagination;

    public $jadwalBelajar;
    public $tanggal;
    public $status = [];
    public $keterangan = [];
    public $catatan_pembelajaran;
    public $absensi = [];
    public $search = '';
    public $filterStatus = '';
    public $statistik = [
        'hadir' => 0,
        'izin' => 0,
        'sakit' => 0,
        'alpha' => 0,
        'belum_diisi' => 0
    ];
    public $selectedSiswa = [];
    public $selectAll = false;
    public $bulkStatus = '';
    public $showRiwayat = false;
    public $riwayatAbsensi = [];
    public $selectedSiswaId = null;
    public $jadwalSebelumnya = [];

    protected $rules = [
        'status.*' => 'required|in:hadir,izin,sakit,alpha',
        'keterangan.*' => 'nullable|string',
        'catatan_pembelajaran' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'status.*.required' => 'Status kehadiran wajib diisi',
        'status.*.in' => 'Status kehadiran tidak valid',
        'catatan_pembelajaran.max' => 'Catatan pembelajaran maksimal 1000 karakter',
    ];

    public function mount($jadwalBelajarId)
    {
        $this->jadwalBelajar = JadwalBelajar::with('kelasBimbel.siswa', 'mataPelajaran')
            ->findOrFail($jadwalBelajarId);
        $this->tanggal = now()->format('Y-m-d');
        $this->loadAbsensi();
        $this->loadJadwalSebelumnya();
    }

    public function getFilteredSiswaProperty(): Collection
    {
        $siswa = $this->jadwalBelajar->kelasBimbel->siswa;

        if ($this->filterStatus === 'belum_diisi') {
            return $siswa->filter(fn ($s) => !isset($this->status[$s->id]));
        }

        if ($this->filterStatus) {
            return $siswa->filter(fn ($s) => ($this->status[$s->id] ?? '') === $this->filterStatus);
        }

        return $siswa;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedSiswa = $this->filteredSiswa->pluck('id')->toArray();
        } else {
            $this->selectedSiswa = [];
        }
    }

    public function updatedSelectedSiswa()
    {
        $this->selectAll = count($this->selectedSiswa) === $this->filteredSiswa->count();
    }

    public function applyBulkStatus()
    {
        if (!$this->bulkStatus) return;

        foreach ($this->selectedSiswa as $siswaId) {
            $this->status[$siswaId] = $this->bulkStatus;
        }

        $this->selectedSiswa = [];
        $this->bulkStatus = '';
        $this->hitungStatistik();
    }

    public function loadRiwayatAbsensi($siswaId)
    {
        $this->selectedSiswaId = $siswaId;
        $this->riwayatAbsensi = Absensi::where('jadwal_belajar_id', $this->jadwalBelajar->id)
            ->where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        $this->showRiwayat = true;
    }

    public function closeRiwayatModal()
    {
        $this->showRiwayat = false;
        $this->selectedSiswaId = null;
        $this->riwayatAbsensi = [];
    }

    #[On('refresh-absensi')]
    public function loadAbsensi()
    {
        $absensiHariIni = Absensi::where('jadwal_belajar_id', $this->jadwalBelajar->id)
            ->where('tanggal', $this->tanggal)
            ->get();

        // Reset status dan keterangan
        $this->status = [];
        $this->keterangan = [];
        $this->absensi = [];
        $this->catatan_pembelajaran = null;

        foreach ($absensiHariIni as $absensi) {
            $this->status[$absensi->siswa_id] = $absensi->status;
            $this->keterangan[$absensi->siswa_id] = $absensi->keterangan;
            $this->absensi[$absensi->siswa_id] = $absensi;
        }

        // Load catatan pembelajaran
        $firstAbsensi = $absensiHariIni->first();
        if ($firstAbsensi) {
            $this->catatan_pembelajaran = $firstAbsensi->catatan_pembelajaran;
        }

        $this->hitungStatistik();
    }

    public function hitungStatistik()
    {
        $this->statistik = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
            'belum_diisi' => 0
        ];

        $totalSiswa = $this->jadwalBelajar->kelasBimbel->siswa->count();

        foreach ($this->status as $status) {
            if (isset($this->statistik[$status])) {
                $this->statistik[$status]++;
            }
        }

        $this->statistik['belum_diisi'] = $totalSiswa - array_sum($this->statistik);
    }

    public function simpanAbsensi()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            foreach ($this->jadwalBelajar->kelasBimbel->siswa as $siswa) {
                if (isset($this->status[$siswa->id])) {
                    Absensi::updateOrCreate(
                        [
                            'jadwal_belajar_id' => $this->jadwalBelajar->id,
                            'siswa_id' => $siswa->id,
                            'tanggal' => $this->tanggal,
                        ],
                        [
                            'tentor_id' => auth()->id(),
                            'mata_pelajaran_id' => $this->jadwalBelajar->mata_pelajaran_id,
                            'status' => $this->status[$siswa->id],
                            'keterangan' => $this->keterangan[$siswa->id] ?? null,
                            'catatan_pembelajaran' => $this->catatan_pembelajaran,
                        ]
                    );
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updatedTanggal()
    {
        $this->loadAbsensi();
    }

    public function getJadwalBelajarProperty()
    {
        return JadwalBelajar::with('kelasBimbel.siswa')
            ->findOrFail($this->jadwalBelajar->id);
    }

    public function getAbsensiProperty()
    {
        return Absensi::where('jadwal_belajar_id', $this->jadwalBelajar->id)
            ->where('tanggal', $this->tanggal)
            ->get()
            ->keyBy('siswa_id');
    }

    public function loadJadwalSebelumnya()
    {
        $this->jadwalSebelumnya = JadwalBelajar::with(['mataPelajaran', 'kelasBimbel', 'absensi'])
            ->where('mata_pelajaran_id', $this->jadwalBelajar->mata_pelajaran_id)
            ->where('kelas_bimbel_id', $this->jadwalBelajar->kelasBimbel_id)
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5)
            ->get();
    }

    private function formatTanggal($tanggal)
    {
        return Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y');
    }

    public function render()
    {
        return view('livewire.tentor.absensi.daftar-absensi');
    }
}
