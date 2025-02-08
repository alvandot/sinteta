<?php

namespace App\Models;

use App\Models\Akademik\Ujian;
use App\Models\Soal\Soal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property-read Soal|null $soal
 * @property-read Ujian|null $ujian
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Jawaban withoutTrashed()
 * @mixin \Eloquent
 */
class Jawaban extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jawabans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ujian_id',
        'soal_id',
        'user_id',
        'jawaban'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jawaban' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the ujian that owns the jawaban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class);
    }

    /**
     * Get the soal that owns the jawaban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Get the user that owns the jawaban.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
