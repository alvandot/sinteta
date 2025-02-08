<?php

namespace App\Models\Akademik;

use App\Models\Akademik\MataPelajaran;
use App\Models\Ruangan;
use App\Models\Users\Tentor;
use App\Models\Users\Siswa;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nama_jadwal
 * @property string $tanggal_mulai
 * @property int $mata_pelajaran_id
 * @property string $hari
 * @property int $ruangan_id
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $ruangan
 * @property string $kelas
 * @property int $tentor_id
 * @property int $kapasitas
 * @property int $jumlah_siswa
 * @property string $status
 * @property string|null $catatan
 * @property int $kelas_bimbel_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read KelasBimbel $kelasBimbel
 * @property-read MataPelajaran $mataPelajaran
 * @property-read Tentor $tentor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Tentor> $tentors
 * @property-read int|null $tentors_count
 * @method static \Database\Factories\Akademik\JadwalBelajarFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereJamMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereJamSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereJumlahSiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereKapasitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereKelasBimbelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereMataPelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereNamaJadwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereRuangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereTentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalBelajar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class JadwalBelajar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_belajars';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_jadwal',
        'tanggal_mulai',
        'mata_pelajaran_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kelas_id',
        'tentor_id',
        'kapasitas',
        'jumlah_siswa',
        'status',
        'catatan',
        'ruangan_id',
        'kelas_bimbel_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
    ];

    /**
     * Get the mata pelajaran associated with the jadwal.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    /**
     * Get the tentor associated with the jadwal.
     */
    public function tentor(): BelongsTo
    {
        return $this->belongsTo(Tentor::class);
    }

    /**
     * Get the kelas bimbel associated with the jadwal.
     */
    public function kelasBimbel(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class);
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }

    /**
     * Get the kelas associated with the jadwal.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class, 'kelas_id');
    }

    /**
     * Get the jumlah siswa from kelas.
     */
    public function getJumlahSiswaAttribute()
    {
        return $this->kelasBimbel->siswa()->where('status', 'aktif')->count();
    }

    /**
     * The tentors that belong to the jadwal.
     */
    public function tentors(): BelongsToMany
    {
        return $this->belongsToMany(Tentor::class, 'jadwal_belajar_tentor')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Get the siswa that belong to the jadwal.
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'jadwal_belajar_siswa')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
