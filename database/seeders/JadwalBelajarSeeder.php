<?php

namespace Database\Seeders;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\MataPelajaran;
use App\Models\Ruangan;
use App\Models\Users\Tentor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JadwalBelajarSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding jadwal belajar...');

        // Ambil data yang diperlukan
        $kelasBimbels = KelasBimbel::all();
        $mataPelajarans = MataPelajaran::all();
        $tentors = Tentor::all();
        $ruangans = Ruangan::where('status', 'aktif')->get();

        // Cek dan buat tentor default jika tidak ada
        if ($tentors->isEmpty()) {
            $this->command->info('Tidak ada tentor yang tersedia. Membuat tentor default...');

            // Buat user untuk tentor default
            $user = User::create([
                'name' => 'Tentor Default',
                'email' => 'tentor.default@cbt.test',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            $user->assignRole('tentor');

            // Buat tentor default
            $tentor = Tentor::factory()->create([
                'user_id' => $user->id,
                'cabang_id' => 1,
            ]);

            $tentors = collect([$tentor]);
        }

        // Cek dan buat ruangan default jika tidak ada
        if ($ruangans->isEmpty()) {
            $this->command->info('Tidak ada ruangan yang aktif. Membuat ruangan default...');
            $ruangan = Ruangan::create([
                'nama' => 'Ruangan Default',
                'kapasitas' => 30,
                'status' => 'aktif'
            ]);
            $ruangans = collect([$ruangan]);
        }

        // Buat jadwal untuk setiap kelas
        foreach ($kelasBimbels as $kelas) {
            $this->command->info("Membuat jadwal untuk kelas {$kelas->nama_kelas}...");

            // Buat 3 jadwal untuk setiap kelas
            for ($i = 0; $i < 3; $i++) {
                $tanggal = Carbon::tomorrow()->addDays(rand(1, 30));
                $jamMulai = str_pad(rand(8, 16), 2, '0', STR_PAD_LEFT) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT);
                $jamSelesai = Carbon::createFromFormat('H:i', $jamMulai)->addHours(2)->format('H:i');

                JadwalBelajar::create([
                    'nama_jadwal' => "Jadwal " . ($i + 1),
                    'kelas_bimbel_id' => $kelas->id,
                    'mata_pelajaran_id' => $mataPelajarans->random()->id,
                    'tentor_id' => $tentors->random()->id,
                    'ruangan_id' => $ruangans->random()->id,
                    'tanggal_mulai' => $tanggal->format('Y-m-d'),
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'keterangan' => 'Jadwal dibuat oleh seeder',
                    'status' => rand(0, 2) == 0 ? 'selesai' : 'berjalan',
                ]);
            }
        }

        $this->command->info('Seeding jadwal belajar selesai!');
    }
}
