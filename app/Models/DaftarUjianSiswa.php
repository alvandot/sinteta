<?php

namespace App\Models;

use App\Models\Akademik\MataPelajaran;
use App\Models\Akademik\Ujian;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HasilUjian|null $hasilUjian
 * @property-read \App\Models\Akademik\MataPelajaran $mataPelajaran
 * @property-read \App\Models\Users\Siswa $siswa
 * @property-read \App\Models\Users\Tentor $tentor
 * @property-read \App\Models\Akademik\Ujian $ujian
 * @method static \Database\Factories\DaftarUjianSiswaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereMataPelajaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereSiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereTentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereUjianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DaftarUjianSiswa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DaftarUjianSiswa extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daftar_ujian_siswas';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mata_pelajaran_id',
        'ujian_id',
        'siswa_id',
        'tentor_id',
        'waktu_mulai_pengerjaan',
        'waktu_selesai_pengerjaan',
        'nilai',
        'status',
        'catatan'
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
        'waktu_mulai_pengerjaan' => 'datetime',
        'waktu_selesai_pengerjaan' => 'datetime',
        'nilai' => 'float'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'belum_mulai',
        'nilai' => null,
        'catatan' => null
    ];

    public const STATUS_BELUM_MULAI = 'belum_mulai';
    public const STATUS_SEDANG_MENGERJAKAN = 'sedang_mengerjakan';
    public const STATUS_SELESAI = 'selesai';

    /**
     * Get the list of available statuses.
     *
     * @return array<string, string>
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_BELUM_MULAI => 'Belum Mulai',
            self::STATUS_SEDANG_MENGERJAKAN => 'Sedang Mengerjakan',
            self::STATUS_SELESAI => 'Selesai'
        ];
    }

    /**
     * Get the siswa that owns the daftar ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id')->withTrashed();
    }

    /**
     * Get the ujian that owns the daftar ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ujian(): BelongsTo
    {
        return $this->belongsTo(Ujian::class, 'ujian_id')->withTrashed();
    }

    /**
     * Get the tentor that owns the daftar ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tentor(): BelongsTo
    {
        return $this->belongsTo(Tentor::class, 'tentor_id')->withTrashed();
    }

    /**
     * Get the mata pelajaran that owns the daftar ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class)->withTrashed();
    }

    /**
     * Get the hasil ujian associated with the daftar ujian.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasilUjian(): HasOne
    {
        return $this->hasOne(HasilUjian::class);
    }

    /**
     * Get the durasi pengerjaan in minutes.
     *
     * @return int|null
     */
    public function getDurasiPengerjaanAttribute(): ?int
    {
        if ($this->waktu_mulai_pengerjaan && $this->waktu_selesai_pengerjaan) {
            return $this->waktu_mulai_pengerjaan->diffInMinutes($this->waktu_selesai_pengerjaan);
        }
        return null;
    }

    /**
     * Scope a query to only include records with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include records with nilai between min and max.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  float  $min
     * @param  float  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNilaiAntara($query, float $min, float $max)
    {
        return $query->whereBetween('nilai', [$min, $max]);
    }

    /**
     * Scope a query to only include records that haven't been graded.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBelumDinilai($query)
    {
        return $query->whereNull('nilai')->where('status', self::STATUS_SELESAI);
    }

    /**
     * Scope a query to only include records that are currently in progress.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSedangBerlangsung($query)
    {
        return $query->where('status', self::STATUS_SEDANG_MENGERJAKAN);
    }

    /**
     * Start the exam.
     *
     * @return bool
     */
    public function mulaiUjian(): bool
    {
        if ($this->status !== self::STATUS_BELUM_MULAI) {
            return false;
        }

        return $this->update([
            'status' => self::STATUS_SEDANG_MENGERJAKAN,
            'waktu_mulai_pengerjaan' => now()
        ]);
    }

    /**
     * Complete the exam.
     *
     * @return bool
     */
    public function selesaikanUjian(): bool
    {
        if ($this->status !== self::STATUS_SEDANG_MENGERJAKAN) {
            return false;
        }

        return $this->update([
            'status' => self::STATUS_SELESAI,
            'waktu_selesai_pengerjaan' => now()
        ]);
    }

    /**
     * Input nilai for the exam.
     *
     * @param  float  $nilai
     * @param  string|null  $catatan
     * @return bool
     */
    public function inputNilai(float $nilai, ?string $catatan = null): bool
    {
        if ($this->status !== self::STATUS_SELESAI) {
            return false;
        }

        return $this->update([
            'nilai' => $nilai,
            'catatan' => $catatan
        ]);
    }
}
