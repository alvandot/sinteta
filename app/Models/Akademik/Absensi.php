<?php

declare(strict_types=1);

namespace App\Models\Akademik;

use App\Models\Users\Siswa;
use App\Models\User;
use App\Models\Users\Tentor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'tanggal',
        'siswa_id',
        'kelas_id',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(KelasBimbel::class, 'kelas_id');
    }

    public function tentor(): BelongsTo
    {
        return $this->belongsTo(Tentor::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jadwalBelajar(): BelongsTo
    {
        return $this->belongsTo(JadwalBelajar::class);
    }
}
