<?php

namespace App\Models\Pivot;

use App\Models\Akademik\MataPelajaran;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $mata_pelajaran_id
 * @property int $tentor_id
 * @property string $status
 * @property string|null $catatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MataPelajaran $mataPelajaran
 * @property-read Tentor $tentor
 * @method static \Database\Factories\Pivot\MataPelajaranTentorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereMataPelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereTentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataPelajaranTentor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MataPelajaranTentor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mata_pelajaran_tentors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tentor_id',
        'mata_pelajaran_id',
        'status',
        'catatan'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the tentor associated with the pivot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tentor()
    {
        return $this->belongsTo(Tentor::class);
    }

    /**
     * Get the mata pelajaran associated with the pivot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
