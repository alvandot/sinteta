<?php

namespace App\Models\Soal;

use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\KelasBimbel;
use App\Models\Soal\Soal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nama
 * @property string|null $deskripsi
 * @property int $mata_pelajaran_id
 * @property string $tingkat
 * @property string $tahun
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MataPelajaran $mataPelajaran
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Soal> $soals
 * @property-read int|null $soals_count
 * @method static \Database\Factories\Soal\PaketSoalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereMataPelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereTingkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaketSoal withoutTrashed()
 * @mixin \Eloquent
 */
class PaketSoal extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paket_soals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'mata_pelajaran_id',
        'tingkat',
        'tahun'
    ];

    /**
     * Get the soals for the paket soal.
     */
    public function soals(): HasMany
    {
        return $this->hasMany(Soal::class);
    }

    public function kelasBimbel(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class, 'kelas_bimbel_id');
    }

    public function ujians(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }

    /**
     * Get the mata pelajaran that owns the paket soal.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
