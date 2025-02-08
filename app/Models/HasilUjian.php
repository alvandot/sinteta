<?php

namespace App\Models;

use App\Models\Akademik\Ujian;
use App\Models\Users\Siswa;
use App\Models\DaftarUjianSiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property int $daftar_ujian_siswa_id
 * @property int $siswa_id
 * @property numeric|null $nilai
 * @property int|null $jawaban_benar
 * @property int|null $jawaban_salah
 * @property string|null $kunci_jawaban
 * @property array<array-key, mixed>|null $jawaban
 * @property string|null $skor
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $waktu_mulai
 * @property \Illuminate\Support\Carbon|null $waktu_selesai
 * @property string|null $status_ujian
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read DaftarUjianSiswa $daftarUjianSiswa
 * @property-read Siswa $siswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereDaftarUjianSiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereJawaban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereJawabanBenar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereJawabanSalah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereKunciJawaban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereSiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereSkor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereStatusUjian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereWaktuMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian whereWaktuSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HasilUjian withoutTrashed()
 * @mixin \Eloquent
 */
class HasilUjian extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hasil_ujians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ujian_id',
        'paket_soal_id',
        'siswa_id',
        'jawaban',
        'total_jawaban_benar',
        'total_jawaban_salah',
        'total_tidak_dijawab',
        'nilai_akhir',
        'detail_penilaian',
        'status',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_pengerjaan',
        'metadata',
        'catatan_khusus'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'total_jawaban_benar' => 'integer',
        'total_jawaban_salah' => 'integer',
        'total_tidak_dijawab' => 'integer',
        'durasi_pengerjaan' => 'integer',
        'nilai_akhir' => 'decimal:2',
        'jawaban' => 'array',
        'detail_penilaian' => 'array',
        'metadata' => 'array'
    ];

    /**
     * Get the daftar ujian siswa that owns the hasil ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function daftarUjianSiswa(): BelongsTo
    {
        return $this->belongsTo(DaftarUjianSiswa::class,'ujian_id','ujian_id');
    }

    /**
     * Get the siswa that owns the hasil ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'ujian_id')->withTrashed();
    }
    /**
     * Mendapatkan statistik jawaban per kategori soal
     */
    public function getStatistikKategori(): array
    {
        $statistik = [];
        $detail = $this->detail_penilaian;

        foreach ($detail as $jawaban) {
            $kategori = $jawaban['jenis_soal'];
            if (!isset($statistik[$kategori])) {
                $statistik[$kategori] = [
                    'total' => 0,
                    'benar' => 0,
                    'salah' => 0,
                    'persentase_benar' => 0
                ];
            }

            $statistik[$kategori]['total']++;
            if ($jawaban['is_correct'] === true) {
                $statistik[$kategori]['benar']++;
            } elseif ($jawaban['is_correct'] === false) {
                $statistik[$kategori]['salah']++;
            }
        }

        // Hitung persentase
        foreach ($statistik as $kategori => $data) {
            $statistik[$kategori]['persentase_benar'] =
                $data['total'] > 0 ? ($data['benar'] / $data['total']) * 100 : 0;
        }

        return $statistik;
    }

    /**
     * Mendapatkan soal-soal yang sering dijawab salah
     */
    public function getSoalSulit(int $limit = 5): array
    {
        $detail = collect($this->detail_penilaian);
        return $detail->filter(fn($item) => $item['is_correct'] === false)
                     ->sortByDesc('bobot')
                     ->take($limit)
                     ->values()
                     ->all();
    }

    /**
     * Mendapatkan durasi pengerjaan dalam format yang mudah dibaca
     */
    public function getDurasiFormatted(): string
    {
        $durasi = $this->durasi_pengerjaan;
        $jam = floor($durasi / 3600);
        $menit = floor(($durasi % 3600) / 60);
        $detik = $durasi % 60;

        $hasil = [];
        if ($jam > 0) $hasil[] = "$jam jam";
        if ($menit > 0) $hasil[] = "$menit menit";
        if ($detik > 0) $hasil[] = "$detik detik";

        return implode(' ', $hasil);
    }

    /**
     * Mendapatkan rekomendasi berdasarkan hasil ujian
     */
    public function getRekomendasi(): array
    {
        $rekomendasi = [];
        $statistik = $this->getStatistikKategori();

        foreach ($statistik as $kategori => $data) {
            if ($data['persentase_benar'] < 60) {
                $rekomendasi[] = [
                    'kategori' => $kategori,
                    'pesan' => "Perlu peningkatan pada soal tipe {$kategori}",
                    'saran' => "Latih lebih banyak soal {$kategori}"
                ];
            }
        }

        return $rekomendasi;
    }
}
