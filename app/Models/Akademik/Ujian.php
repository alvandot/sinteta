<?php

namespace App\Models\Akademik;

use App\Models\DaftarUjianSiswa;
use App\Models\Soal\PaketSoal;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\KelasBimbel;

/**
 * 
 *
 * @property int $id
 * @property string $nama
 * @property string|null $deskripsi
 * @property string $tanggal_ujian
 * @property \Illuminate\Support\Carbon $waktu_mulai
 * @property \Illuminate\Support\Carbon $waktu_selesai
 * @property int $durasi
 * @property int $paket_soal_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DaftarUjianSiswa> $daftarUjianSiswa
 * @property-read int|null $daftar_ujian_siswa_count
 * @property-read \App\Models\Akademik\MataPelajaran|null $mataPelajaran
 * @property-read PaketSoal $paketSoal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Siswa> $siswa
 * @property-read int|null $siswa_count
 * @property-read Tentor|null $tentor
 * @method static \Database\Factories\Akademik\UjianFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereDurasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian wherePaketSoalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereTanggalUjian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereWaktuMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian whereWaktuSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ujian withoutTrashed()
 * @mixin \Eloquent
 */
class Ujian extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ujians';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
        'durasi',
        'paket_soal_id',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'durasi' => 'integer'
    ];

    /**
     * Get the siswa that belong to the ujian.
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'daftar_ujian_siswas')
            ->withTimestamps();
    }

    /**
     * Get the tentor that owns the ujian.
     */
    public function tentor()
    {
        return $this->belongsTo(Tentor::class);
    }

    /**
     * Get the paket soal that owns the ujian.
     */
    public function paketSoal(): BelongsTo
    {
        return $this->belongsTo(PaketSoal::class)->with('soals');
    }

    /**
     * Get the daftar ujian siswa for the ujian.
     */
    public function daftarUjianSiswa(): HasMany
    {
        return $this->hasMany(DaftarUjianSiswa::class, 'ujian_id');
    }

    /**
     * Get the kelas that owns the ujian.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class, 'kelas_id');
    }

    /**
     * Get the mata pelajaran that owns the ujian.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }
}
