<?php

namespace App\Models\Soal;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model SoalKunciJawaban untuk mengelola kunci jawaban soal
 *
 * @property int $id
 * @property int $soal_id
 * @property string $label
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read Soal $soal
 * @property-read User|null $creator
 * @property-read User|null $updater
 */
class SoalKunciJawaban extends Model
    {

    use HasFactory, SoftDeletes;

    protected $table = 'soal_kunci_jawaban';

    /**
     * Label opsi yang valid
     */
    const VALID_LABELS = [ 'A', 'B', 'C', 'D', 'E' ];

    protected $fillable = [ 
        'soal_id',
        'label',     // A, B, C, D, E
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [ 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relationship dengan Soal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soal () : BelongsTo
        {

        return $this->belongsTo ( Soal::class);
        }

    /**
     * Relationship dengan User (creator)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator () : BelongsTo
        {

        return $this->belongsTo ( User::class, 'created_by' );
        }

    /**
     * Relationship dengan User (updater)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater () : BelongsTo
        {

        return $this->belongsTo ( User::class, 'updated_by' );
        }

    /**
     * Check if label is valid
     *
     * @param string $label
     * @return bool
     */
    public static function isValidLabel ( string $label ) : bool
        {

        return in_array ( strtoupper ( $label ), self::VALID_LABELS );
        }

    /**
     * Boot the model
     */
    protected static function boot ()
        {

        parent::boot ();

        static::creating (

            function ($model)
                {
                if ( auth ()->check () )
                    {
                    $model->created_by = auth ()->id ()
                    ;
                    }
                }
        );

        static::updating (

            function ($model)
                {
                if ( auth ()->check () )
                    {
                    $model->updated_by = auth ()->id ()
                    ;
                    }
                }
        );
        }

    }
