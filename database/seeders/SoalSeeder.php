<?php

namespace Database\Seeders;

use App\Models\Soal\{Soal, SoalOpsi};
use Illuminate\Database\Seeder;

class SoalSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->command->info('Seeding soal...');

        // Buat soal untuk setiap paket soal
        \App\Models\Soal\PaketSoal::all()->each(

            function ($paketSoal) {
                // Buat 5-10 soal per paket
                $jumlahSoal = rand(5, 10);
                
                // Hitung bobot per soal agar total 100
                $bobotPerSoal = 100 / $jumlahSoal;

                for ($i = 1; $i <= $jumlahSoal; $i++) {
                    // Buat soal
                    $jenisSoal = collect(['pilihan_ganda', 'multiple_choice', 'essay'])->random()
                    ;

                    $soal = Soal::create([
                        'paket_soal_id' => $paketSoal->id,
                        'nomor_urut' => $i,
                        'jenis_soal' => $jenisSoal,
                        'pertanyaan' => "Pertanyaan untuk {$paketSoal->nama} nomor {$i}",
                        'bobot' => $bobotPerSoal,
                        'metadata' => [
                            'tingkat_kesulitan' => collect(['mudah', 'sedang', 'sulit'])->random(),
                            'waktu_pengerjaan' => rand(1, 5),
                        ],
                    ]);

                    // Buat opsi jawaban untuk pilihan ganda dan multiple choice
                    if (in_array($jenisSoal, ['pilihan_ganda', 'multiple_choice'])) {
                        $labels = ['A', 'B', 'C', 'D', 'E'];
                        $jawabanBenar = $jenisSoal === 'pilihan_ganda' ?
                            [collect($labels)->random()] :
                            collect($labels)->random(rand(2, 3))
                                ->values()
                                ->all()
                        ;

                        foreach ($labels as $index => $label) {
                            SoalOpsi::create([
                                'soal_id' => $soal->id,
                                'label' => $label,
                                'jenis_soal' => $jenisSoal,
                                'teks' => "Opsi jawaban {$label} untuk soal nomor {$i}",
                                'is_jawaban' => in_array($label, $jawabanBenar),
                                'urutan' => $index + 1,
                            ]);
                        }

                        // Update kunci jawaban sesuai jenis soal
                        if ($jenisSoal === 'pilihan_ganda') {
                            $soal->update(['kunci_pg' => $jawabanBenar[0]]);
                        } else {
                            $soal->update(['kunci_multiple_choice' => $jawabanBenar]);
                        }
                    } else {
                        // Untuk soal essay
                        $soal->update([
                            'kunci_essay' => "Kunci jawaban essay untuk soal nomor {$i}",
                        ]);
                    }
                }

                $this->command->info("Berhasil membuat {$jumlahSoal} soal untuk paket {$paketSoal->nama}");
            }
        )
        ;

        $this->command->info('Seeding soal selesai!');
    }

}
