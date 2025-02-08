<?php

namespace App\Models\Akademik;

use App\Models\Pivot\MataPelajaranTentor;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nama_pelajaran
 * @property string $kode_pelajaran
 * @property string|null $deskripsi
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Akademik\JadwalBelajar> $jadwalBelajars
 * @property-read int|null $jadwal_belajars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tentor> $tentors
 * @property-read int|null $tentors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Akademik\Ujian> $ujians
 * @property-read int|null $ujians_count
 * @method static \Database\Factories\Akademik\MataPelajaranFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereKodePelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereNamaPelajaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MataPelajaran extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'mata_pelajarans';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pelajaran',
        'kode_pelajaran',
        'deskripsi',
        'is_active'
    ];

    /**
     * Atribut yang harus dikonversi.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Menunjukkan apakah model harus mencatat waktu.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Mendapatkan jadwal belajar untuk mata pelajaran ini.
     */
    public function jadwalBelajars(): HasMany
    {
        return $this->hasMany(JadwalBelajar::class);
    }

    public function ujians(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Mendapatkan daftar tentor yang mengajar mata pelajaran ini.
     */
    public function tentors(): BelongsToMany
    {
        return $this->belongsToMany(Tentor::class, 'mata_pelajaran_tentors')
            ->withPivot(['status', 'catatan'])
            ->withTimestamps();
    }

    /**
     * Get the daftar ujian siswa for this mata pelajaran.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daftarUjianSiswas(): HasMany
    {
        return $this->hasMany(\App\Models\DaftarUjianSiswa::class);
    }

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
