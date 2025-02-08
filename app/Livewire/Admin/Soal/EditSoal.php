<?php

namespace App\Livewire\Admin\Soal;

use App\Models\Soal\PaketSoal;
use App\Models\Akademik\MataPelajaran;
use App\Models\Soal\SoalOpsi;
use App\Models\Soal\Soal;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Mary\Traits\Toast;

#[Layout('components.layouts.app')]
class EditSoal extends Component
{
    use WithFileUploads;
    use Toast;

    public $paketSoal;
    public $soals;
    public $nama;
    public $deskripsi;
    public $mata_pelajaran_id;
    public $tingkats = [
        ['id' => 1, 'nama' => 'SD'],
        ['id' => 2, 'nama' => 'SMP'],
        ['id' => 3, 'nama' => 'SMA'],
        ['id' => 4, 'nama' => 'SMK'],
        ['id' => 5, 'nama' => 'MA'],
        ['id' => 6, 'nama' => 'MAK'],
        ['id' => 7, 'nama' => 'MAK'],
        ['id' => 8, 'nama' => 'MAK'],
        ['id' => 9, 'nama' => 'MAK'],
        ['id' => 10, 'nama' => 'MAK'],
    ];


    public $tahun;

    public $mataPelajarans;

    public $opsiJawaban = [];
    public $opsiTeks = [];
    public $kunciEssay = [];

    public function mount($id)
    {
        $this->paketSoal = PaketSoal::findOrFail($id);
        $this->nama = $this->paketSoal->nama;
        $this->deskripsi = $this->paketSoal->deskripsi;
        $this->mata_pelajaran_id = $this->paketSoal->mataPelajaran->id;
        $this->tingkat = $this->paketSoal->tingkat;
        $this->tahun = $this->paketSoal->tahun;

        $this->mataPelajarans = MataPelajaran::all();
        $this->getSoal();

        // Initialize opsi jawaban dan teks
        foreach ($this->soals as $soal) {
            foreach ($soal->soalOpsi as $opsi) {
                $this->opsiJawaban[$soal->id][$opsi->id] = $opsi->is_jawaban;
                $this->opsiTeks[$soal->id][$opsi->id] = $opsi->teks;
            }
            if ($soal->jenis_soal == 'essay') {
                $this->kunciEssay[$soal->id] = $soal->kunci_essay;
            }
        }
    }


    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tingkat' => 'required|string',
            'tahun' => 'required|string|max:4'
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        try {
            $this->paketSoal->update($validated);

            $this->success('Paket soal berhasil diperbarui');

            return redirect()->route('admin.soal.index');

        } catch (\Exception $e) {
            $this->error('Terjadi kesalahan saat memperbarui paket soal');
        }
    }

    public function getSoal()
    {
        $this->soals = $this->paketSoal->soals;
    }

    public function updatedOpsiJawaban($value, $key)
    {
        [$soalId, $opsiId] = explode('.', $key);

        $soal = Soal::find($soalId);

        // Jika soal pilihan ganda
        if ($soal->jenis_soal == Soal::JENIS_PILIHAN_GANDA) {
            // Reset semua opsi jawaban untuk soal ini menjadi false
            SoalOpsi::where('soal_id', $soalId)->update(['is_jawaban' => false]);

            // Set opsi yang dipilih menjadi true
            $opsiTerpilih = SoalOpsi::where('id', $opsiId)->first();
            $opsiTerpilih->update(['is_jawaban' => true]);

            // Update kunci_pg di tabel soal
            $soal->update([
                'kunci_pg' => $opsiTerpilih->label,
                'kunci_multiple_choice' => null,
                'kunci_essay' => null
            ]);

            // Update state lokal
            foreach ($this->opsiJawaban[$soalId] as $key => $value) {
                $this->opsiJawaban[$soalId][$key] = false;
            }
            $this->opsiJawaban[$soalId][$opsiId] = true;

        } elseif ($soal->jenis_soal == Soal::JENIS_MULTIPLE_CHOICE) {
            // Update opsi jawaban
            SoalOpsi::where('id', $opsiId)
                ->where('soal_id', $soalId)
                ->update(['is_jawaban' => $value]);

            // Update kunci_multiple_choice di tabel soal
            $kunciJawaban = $soal->soalOpsi()
                ->where('is_jawaban', true)
                ->pluck('label')
                ->toArray();

            $soal->update([
                'kunci_multiple_choice' => $kunciJawaban,
                'kunci_pg' => null,
                'kunci_essay' => null
            ]);
        } elseif ($soal->jenis_soal == Soal::JENIS_ESSAY) {
            $soal->update([
                'kunci_essay' => $value,
                'kunci_pg' => null,
                'kunci_multiple_choice' => null
            ]);
        }

        $this->success('Jawaban berhasil diperbarui');
    }

    public function updatedOpsiTeks($value, $key)
    {
        [$soalId, $opsiId] = explode('.', $key);

        // Update teks opsi di database
        SoalOpsi::where('id', $opsiId)
            ->where('soal_id', $soalId)
            ->update(['teks' => $value]);

        $this->success('Opsi jawaban berhasil diperbarui');
    }

    public function updatedKunciEssay($value, $key)
    {
        $soal = Soal::find($key);

        // Update kunci essay di database
        $soal->update([
            'kunci_essay' => $value,
            'kunci_pg' => null,
            'kunci_multiple_choice' => null
        ]);

        $this->success('Kunci essay berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.admin.soal.edit-soal', [
            'paketSoal' => $this->paketSoal,
        ]);
    }
}
