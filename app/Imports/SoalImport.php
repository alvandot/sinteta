<?php

namespace App\Imports;

use App\Models\Soal\PaketSoal;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $mataPelajaranId;
    protected $tingkat;
    protected $tahun;

    public function __construct($mataPelajaranId, $tingkat, $tahun)
    {
        $this->mataPelajaranId = $mataPelajaranId;
        $this->tingkat = $tingkat;
        $this->tahun = $tahun;
    }

    public function collection(Collection $rows)
    {
        $paketSoalData = [];
        
        foreach ($rows as $row) {
            $paketNama = $row['nama_soal'];
            
            if (!isset($paketSoalData[$paketNama])) {
                $paketSoalData[$paketNama] = [
                    'nama' => $paketNama,
                    'mata_pelajaran_id' => $this->mataPelajaranId,
                    'tingkat' => $this->tingkat,
                    'tahun' => $this->tahun,
                    'soals' => []
                ];
            }

            $paketSoalData[$paketNama]['soals'][] = [
                'pertanyaan' => $row['pertanyaan'],
                'jenis_soal' => $row['jenis_soal'],
                'pilihan_a' => $row['pilihan_a'],
                'pilihan_b' => $row['pilihan_b'],
                'pilihan_c' => $row['pilihan_c'],
                'pilihan_d' => $row['pilihan_d'],
                'jawaban_benar' => $row['jawaban_benar'],
                'pembahasan' => $row['pembahasan'],
                'bobot' => $row['bobot'],
            ];
        }

        foreach ($paketSoalData as $data) {
            $paketSoal = PaketSoal::create([
                'nama' => $data['nama'],
                'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                'tingkat' => $data['tingkat'],
                'tahun' => $data['tahun'],
            ]);

            foreach ($data['soals'] as $soalData) {
                $paketSoal->soals()->create($soalData);
            }
        }
    }
} 