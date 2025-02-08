<?php

namespace App\Models;

use App\Models\User;
use App\Models\Users\Siswa;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string|null $kontak
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Siswa> $siswas
 * @property-read int|null $siswas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereKontak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cabang withoutTrashed()
 * @mixin \Eloquent
 */
class Cabang extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'cabangs';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_cabang',
        'alamat',
        'kontak'
    ];

    /**
     * Mendapatkan daftar user yang terkait dengan cabang ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Mendapatkan daftar siswa yang terkait dengan cabang ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswas(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function tentor(): HasMany
    {
        return $this->hasMany(Tentor::class);
    }
}
