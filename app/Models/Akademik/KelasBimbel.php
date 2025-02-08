<?php

namespace App\Models\Akademik;

use App\Models\Cabang;
use App\Models\Soal\PaketSoal;
use App\Models\Users\Siswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nama_kelas
 * @property int $cabang_id
 * @property string|null $deskripsi
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Cabang $cabang
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Akademik\JadwalBelajar> $jadwalBelajar
 * @property-read int|null $jadwal_belajar_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Siswa> $siswas
 * @property-read int|null $siswas_count
 * @method static \Database\Factories\Akademik\KelasBimbelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereCabangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereNamaKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KelasBimbel withoutTrashed()
 * @mixin \Eloquent
 */
class KelasBimbel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kelas_bimbels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kelas',
        'cabang_id',
        'deskripsi',
        'tingkat_kelas',
        'jurusan',
        'program_bimbel',
        'kapasitas',
        'biaya_pendaftaran',
        'biaya_bulanan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the siswa for the kelas bimbel.
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Get the jadwal for the kelas bimbel.
     */
    public function jadwal(): HasMany
    {
        return $this->hasMany(JadwalBelajar::class);
    }

    /**
     * Get the ujian for the kelas bimbel.
     */
    public function ujian(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }

    public function paketSoal(): HasMany
    {
        return $this->hasMany(PaketSoal::class, 'kelas_bimbel_id');
    }

    /**
     * Get the cabang that owns the kelas bimbel.
     */
    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    protected $casts = [
        'kapasitas' => 'integer',
    ];
}
