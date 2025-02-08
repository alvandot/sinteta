<?php

namespace App\Models\Users;

use App\Models\Akademik\JadwalBelajar;
use App\Models\Akademik\MataPelajaran;
use App\Models\Cabang;
use App\Models\DaftarUjianSiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $jenis_kelamin
 * @property \Illuminate\Support\Carbon $tanggal_lahir
 * @property string $alamat
 * @property string $no_telepon
 * @property string $pendidikan_terakhir
 * @property string $jurusan
 * @property string $spesialisasi
 * @property string|null $foto
 * @property string $status
 * @property \Illuminate\Support\Carbon $tanggal_bergabung
 * @property \Illuminate\Support\Carbon|null $tanggal_berakhir
 * @property string|null $catatan
 * @property numeric $gaji_pokok
 * @property numeric|null $tunjangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JadwalBelajar> $jadwalBelajars
 * @property-read int|null $jadwal_belajars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MataPelajaran> $mapels
 * @property-read int|null $mapels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DaftarUjianSiswa> $ujianSiswaTentors
 * @property-read int|null $ujian_siswa_tentors_count
 * @property-read User $user
 * @method static \Database\Factories\Users\TentorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereGajiPokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor wherePendidikanTerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereSpesialisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereTanggalBerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereTanggalBergabung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereTunjangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tentor withoutTrashed()
 * @mixin \Eloquent
 */
class Tentor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tentors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'pendidikan_terakhir',
        'jurusan',
        'spesialisasi',
        'foto',
        'status',
        'tanggal_bergabung',
        'tanggal_berakhir',
        'catatan',
        'gaji_pokok',
        'tunjangan'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'tanggal_berakhir' => 'date',
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'decimal:2'
    ];

    /**
     * Get the user that owns the tentor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mata pelajaran that belong to the tentor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mapels(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'mata_pelajaran_tentors')
                    ->withPivot('status');
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    /**
     * Get the jadwal belajar for the tentor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwalBelajars(): HasMany
    {
        return $this->hasMany(JadwalBelajar::class);
    }

    /**
     * Get the daftar ujian siswa for the tentor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSiswaTentors(): HasMany
    {
        return $this->hasMany(DaftarUjianSiswa::class);
    }
}
