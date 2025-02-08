<?php

namespace App\Models\Users;

use App\Models\Akademik\KelasBimbel;
use App\Models\Akademik\Ujian;
use App\Models\Akademik\JadwalBelajar;
use App\Models\Cabang;
use App\Models\DaftarUjianSiswa;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Akademik\Absensi;

/**
 *
 *
 * @property int $id
 * @property string $nama_lengkap
 * @property string $email
 * @property string $password
 * @property string $jenis_kelamin
 * @property \Illuminate\Support\Carbon $tanggal_lahir
 * @property string $alamat
 * @property string $no_telepon
 * @property string $asal_sekolah
 * @property string $kelas
 * @property string|null $jurusan
 * @property string $nama_wali
 * @property string $no_telepon_wali
 * @property string|null $foto
 * @property string $status
 * @property string $tanggal_bergabung
 * @property string|null $tanggal_berakhir
 * @property string|null $catatan
 * @property int $kelas_bimbel_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Ujian> $daftarUjianSiswa
 * @property-read int|null $daftar_ujian_siswa_count
 * @property-read int $total_siswa
 * @property-read KelasBimbel $kelasBimbel
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, DaftarUjianSiswa> $ujianSiswaTentors
 * @property-read int|null $ujian_siswa_tentors_count
 * @method static \Database\Factories\Users\SiswaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereAsalSekolah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereKelasBimbelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereNamaWali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereNoTeleponWali($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereTanggalBerakhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereTanggalBergabung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Siswa withoutRole($roles, $guard = null)
 * @mixin \Eloquent
 */
class Siswa extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * Guard yang digunakan oleh model.
     *
     * @var string
     */
    protected $guard = 'siswa';

    /**
     * Tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'siswas';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'cabang_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'asal_sekolah',
        'kelas',
        'jurusan',
        'nama_wali',
        'no_telepon_wali',
        'foto',
        'status',
        'tanggal_bergabung',
        'tanggal_berakhir',
        'catatan',
        'kelas_bimbel_id'
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus dikonversi.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
        'tanggal_berakhir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Mendapatkan kelas bimbel yang dimiliki oleh siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelasBimbel(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class);
    }

    /**
     * Mendapatkan daftar ujian siswa dan tentor untuk siswa ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianSiswaTentors(): HasMany
    {
        return $this->hasMany(DaftarUjianSiswa::class);
    }

    /**
     * Mendapatkan daftar ujian yang diikuti oleh siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function daftarUjianSiswa(): BelongsToMany
    {
        return $this->belongsToMany(Ujian::class, 'ujian_siswa_tentors')
            ->withPivot('status', 'nilai', 'waktu_mulai', 'waktu_selesai')
            ->withTimestamps();
    }

    /**
     * Mendapatkan total jumlah siswa.
     *
     * @return int
     */
    public function getTotalSiswaAttribute(): int
    {
        return $this->count();
    }

    /**
     * Mendapatkan jadwal belajar yang diikuti oleh siswa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jadwalBelajar(): BelongsToMany
    {
        return $this->belongsToMany(JadwalBelajar::class, 'jadwal_belajar_siswa')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Mendapatkan cabang yang terkait dengan siswa ini.
     */
    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
