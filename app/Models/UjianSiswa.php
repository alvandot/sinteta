<?php

namespace App\Models;

use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use App\Models\DaftarUjianSiswa as Ujian;
use App\Models\HasilUjian;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $mata_pelajaran_id
 * @property int $ujian_id
 * @property int $siswa_id
 * @property int $tentor_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read HasilUjian|null $hasilUjian
 * @property-read Siswa $siswa
 * @property-read Tentor $tentor
 * @property-read Ujian $ujian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereMataPelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereSiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereTentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereUjianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UjianSiswa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UjianSiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daftar_ujian_siswas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ujian_id',
        'siswa_id',
        'tentor_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the ujian that owns the ujian siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class);
    }

    /**
     * Get the siswa that owns the ujian siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the tentor that owns the ujian siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tentor(): BelongsTo
    {
        return $this->belongsTo(Tentor::class);
    }

    /**
     * Get the hasil ujian associated with the ujian siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasilUjian(): HasOne
    {
        return $this->hasOne(HasilUjian::class);
    }
}
