<?php

namespace App\Livewire\Admin\Jadwal;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use App\Models\Ruangan;
use App\Models\Users\Tentor;
use App\Models\Akademik\MataPelajaran;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class BuatJadwal extends Component
{
    use Toast;

    public $tanggal_mulai;
    public $jam_mulai;
    public $jam_selesai;
    public $kelas_bimbel_id;
    public $mata_pelajaran_id;
    public $tentor_id;
    public $keterangan;
    public $ruangan_id;

    public function mount()
    {
        // Set tanggal_mulai ke besok
        $this->tanggal_mulai = Carbon::tomorrow()->format('Y-m-d');
    }

    public function getJadwalBesokProperty()
    {
        return JadwalBelajar::with(['mataPelajaran', 'kelasBimbel', 'tentor.user'])
            ->whereDate('tanggal_mulai', Carbon::tomorrow())
            ->orderBy('jam_mulai')
            ->get();
    }

    public function rules()
    {
        return [
            'tanggal_mulai' => 'required|date|after_or_equal:' . Carbon::tomorrow()->format('Y-m-d'),
            'jam_mulai' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->tanggal_mulai || !$this->jam_selesai || !$this->tentor_id) {
                        return;
                    }

                    $jadwalBentrok = JadwalBelajar::where('tentor_id', $this->tentor_id)
                        ->where('tanggal_mulai', $this->tanggal_mulai)
                        ->where(function ($query) use ($value) {
                            $query->where(function ($q) use ($value) {
                                // Cek apakah waktu mulai berada di antara jadwal yang sudah ada
                                $q->whereTime('jam_mulai', '<=', $value)
                                    ->whereTime('jam_selesai', '>', $value);
                            })->orWhere(function ($q) {
                                // Cek apakah waktu selesai berada di antara jadwal yang sudah ada
                                $q->whereTime('jam_mulai', '<', $this->jam_selesai)
                                    ->whereTime('jam_selesai', '>=', $this->jam_selesai);
                            });
                        })
                        ->exists();

                    if ($jadwalBentrok) {
                        $fail('Tentor sudah memiliki jadwal di waktu yang sama.');
                    }
                },
            ],
            'jam_selesai' => 'required|after:jam_mulai',
            'kelas_bimbel_id' => 'required|exists:kelas_bimbels,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tentor_id' => 'required|exists:users,id',
            'keterangan' => 'nullable|string|max:255',
            'ruangan_id' => 'required|exists:ruangans,id',
        ];
    }

    public function messages()
    {
        return [
            'tanggal_mulai.required' => 'Tanggal harus diisi',
            'tanggal_mulai.date' => 'Format tanggal tidak valid',
            'tanggal_mulai.after_or_equal' => 'Tanggal minimal besok',
            'jam_mulai.required' => 'Jam mulai harus diisi',
            'jam_selesai.required' => 'Jam selesai harus diisi',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'kelas_bimbel_id.required' => 'Kelas harus dipilih',
            'kelas_bimbel_id.exists' => 'Kelas tidak valid',
            'mata_pelajaran_id.required' => 'Mata pelajaran harus dipilih',
            'mata_pelajaran_id.exists' => 'Mata pelajaran tidak valid',
            'tentor_id.required' => 'Tentor harus dipilih',
            'tentor_id.exists' => 'Tentor tidak valid',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
            'ruangan_id.required' => 'Ruangan harus dipilih',
            'ruangan_id.exists' => 'Ruangan tidak valid',
        ];
    }

    protected function getNamaHari($date)
    {
        $hari = Carbon::parse($date)->locale('id')->dayName;
        return ucfirst($hari);
    }

    public function simpan()
    {
        try {
            $validated = $this->validate();
            $kelas = KelasBimbel::find($validated['kelas_bimbel_id']);
            $mapel = MataPelajaran::find($validated['mata_pelajaran_id']);
            $tanggal = Carbon::parse($validated['tanggal_mulai']);

            // Generate nama jadwal otomatis
            $validated['nama_jadwal'] = "{$mapel->nama_pelajaran} - {$kelas->nama_kelas} - " . $tanggal->format('d/m/Y');

            JadwalBelajar::create($validated);

            $this->success(
                title: 'Berhasil!',
                description: 'Jadwal berhasil dibuat untuk ' . $tanggal->locale('id')->isoFormat('dddd, D MMMM Y')
            );

            // Reset form dan set tanggal_mulai ke besok lagi
            $this->reset(['jam_mulai', 'jam_selesai', 'kelas_bimbel_id', 'mata_pelajaran_id', 'tentor_id', 'keterangan']);
            $this->tanggal_mulai = Carbon::tomorrow()->format('Y-m-d');
        } catch (\Exception $e) {
            $this->error(
                title: 'Gagal!',
                description: 'Terjadi kesalahan saat membuat jadwal. ' . $e->getMessage()
            );
        }
    }

    public function updated($property)
    {
        if (in_array($property, ['jam_mulai', 'jam_selesai', 'tanggal_mulai', 'tentor_id'])) {
            try {
                $this->validateOnly($property);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->warning(
                    title: 'Perhatian!',
                    description: $e->validator->errors()->first()
                );
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.jadwal.buat-jadwal', [
            'daftarKelas' => KelasBimbel::all(),
            'daftarMapel' => MataPelajaran::all(),
            'daftarGuru' => Tentor::with('user', 'mapels')
                ->whereHas('mapels', function ($query) {
                    $query->where('id', $this->mata_pelajaran_id);
                })
                ->get(),
            'daftarRuangan' => Ruangan::where('status', 'aktif')->get(),
            'jadwalBesok' => $this->jadwalBesok
        ]);
    }
}
