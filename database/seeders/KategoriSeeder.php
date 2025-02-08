<?php

namespace Database\Seeders;

use App\Models\Soal\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Pengetahuan',
                'deskripsi' => 'Soal-soal yang menguji pemahaman konsep dan teori'
            ],
            [
                'nama' => 'Pemahaman',
                'deskripsi' => 'Soal-soal yang menguji kemampuan memahami dan menjelaskan'
            ],
            [
                'nama' => 'Penerapan',
                'deskripsi' => 'Soal-soal yang menguji kemampuan menerapkan konsep'
            ],
            [
                'nama' => 'Analisis',
                'deskripsi' => 'Soal-soal yang menguji kemampuan menganalisis'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
