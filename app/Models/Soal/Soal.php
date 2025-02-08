<?php

namespace App\Models\Soal;

use App\Models\HasilUjian;
use App\Models\Soal\PaketSoal;
use App\Models\User;
use App\Models\Jawaban;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Soal untuk mengelola soal-soal ujian
 *
 * @property int $id
 * @property int $paket_soal_id
 * @property int $nomor_urut
 * @property string $jenis_soal
 * @property string $pertanyaan
 * @property string|null $kunci_pg
 * @property string|null $kunci_multiple_choice
 * @property string|null $kunci_essay
 * @property string|null $gambar
 * @property int $bobot
 * @property array|null $metadata
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read PaketSoal $paketSoal
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection|SoalOpsi[] $soalOpsiRelation
 * @property-read \Illuminate\Database\Eloquent\Collection|Jawaban[] $jawaban
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Soal jenisSoal(string $jenis)
 */
class Soal extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'soals';

    // Konstanta untuk jenis soal
    const JENIS_PILIHAN_GANDA = 'pilihan_ganda';
    const JENIS_MULTIPLE_CHOICE = 'multiple_choice';
    const JENIS_ESSAY = 'essay';

    protected $fillable = [
        'paket_soal_id',
        'nomor_urut',
        'pertanyaan',
        'jenis_soal',
        'kunci_pg',
        'kunci_multiple_choice',
        'kunci_essay',
        'gambar',
        'bobot',
        'metadata',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'bobot' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'kunci_multiple_choice' => 'array',
    ];

    /**
     * Get valid jenis soal options
     *
     * @return array<string>
     */
    public static function getJenisSoal(): array
    {

        return [
            self::JENIS_PILIHAN_GANDA,
            self::JENIS_MULTIPLE_CHOICE,
            self::JENIS_ESSAY,
        ];
    }

    /**
     * Relationship with PaketSoal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paketSoal(): BelongsTo
    {

        return $this->belongsTo(PaketSoal::class);
    }


    public function soalOpsi(): HasMany
    {
        return $this->hasMany(SoalOpsi::class);
    }

    /**
     * Relationship with OpsiJawabanPG
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opsiJawabanPG(): HasMany
    {

        return $this->hasMany(SoalOpsi::class)
            ->where('jenis_soal', self::JENIS_PILIHAN_GANDA)
            ->orderBy('urutan')
        ;
    }

    /**
     * Relationship with OpsiJawabanMultipleChoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opsiJawabanMultipleChoice(): HasMany
    {

        return $this->hasMany(SoalOpsi::class)
            ->where('jenis_soal', self::JENIS_MULTIPLE_CHOICE)
            ->orderBy('urutan')
        ;
    }

    /**
     * Relationship with OpsiJawabanEssay
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opsiJawabanEssay(): HasMany
    {

        return $this->hasMany(SoalOpsi::class)
            ->where('jenis_soal', self::JENIS_ESSAY)
            ->orderBy('urutan')
        ;
    }

    /**
     * Get all jawaban for this soal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jawaban(): HasMany
    {

        return $this->hasMany(Jawaban::class);
    }

    /**
     * Relationship with User (creator)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {

        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship with User (updater)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater(): BelongsTo
    {

        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all opsi jawaban
     */
    public function soalOpsiRelation(): HasMany
    {
        return $this->hasMany(SoalOpsi::class)
            ->orderBy('urutan');
    }

    /**
     * Get opsi jawaban
     */
    public function getOpsiAttribute()
    {
        return $this->soalOpsiRelation;
    }

    /**
     * Scope to filter by jenis soal
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $jenis
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJenisSoal($query, string $jenis)
    {
        return $query->where('jenis_soal', $jenis);
    }

    /**
     * Check if soal is pilihan ganda
     */
    public function isPilihanGanda(): bool
    {
        return $this->jenis_soal === self::JENIS_PILIHAN_GANDA;
    }

    /**
     * Check if soal is multiple choice
     */
    public function isMultipleChoice(): bool
    {
        return $this->jenis_soal === self::JENIS_MULTIPLE_CHOICE;
    }

    /**
     * Check if soal is essay
     */
    public function isEssay(): bool
    {

        return $this->jenis_soal === self::JENIS_ESSAY;
    }

    /**
     * Check if soal has gambar
     */
    public function hasGambar(): bool
    {
        return !empty($this->gambar);
    }

    /**
     * Get formatted bobot
     */
    public function getBobotFormattedAttribute(): string
    {
        return number_format($this->bobot, 2);
    }



    /**
     * Boot the model
     */
    protected static function boot()
    {

        parent::boot();

        static::creating(

            function ($soal) {
                if (auth()->check()) {
                    $soal->created_by = auth()->id()
                    ;
                }
            }
        );

        static::updating(

            function ($soal) {
                if (auth()->check()) {
                    $soal->updated_by = auth()->id()
                    ;
                }
            }
        );
    }

}
