<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua cabang
        $cabangs = Cabang::all();

        // Untuk setiap cabang, buat 10 ruangan
        foreach ($cabangs as $cabang) {
            for ($i = 1; $i <= 10; $i++) {
                Ruangan::create([
                    'cabang_id' => $cabang->id,
                    'nama' => "Ruangan {$i}",
                    'kode' => "R{$cabang->id}{$i}",
                    'kapasitas' => rand(20, 40),
                    'deskripsi' => "Ruangan {$i} di cabang {$cabang->nama}",
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
