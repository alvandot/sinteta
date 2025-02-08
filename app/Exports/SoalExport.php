<?php

namespace App\Exports;

use App\Models\Soal\PaketSoal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SoalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $query = PaketSoal::with(['soals']);
        if ($this->id) {
            $query->where('id', $this->id);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Soal',
            'Pertanyaan',
            'Jenis Soal',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Jawaban Benar',
            'Pembahasan',
            'Bobot'
        ];
    }

    public function map($paketSoal): array
    {
        $rows = [];
        foreach ($paketSoal->soals as $soal) {
            $rows[] = [
                $paketSoal->nama,
                strip_tags($soal->pertanyaan),
                $soal->jenis_soal,
                $soal->pilihan_a ?? '',
                $soal->pilihan_b ?? '',
                $soal->pilihan_c ?? '',
                $soal->pilihan_d ?? '',
                $soal->jawaban_benar,
                strip_tags($soal->pembahasan ?? ''),
                $soal->bobot
            ];
        }
        return $rows;
    }
}