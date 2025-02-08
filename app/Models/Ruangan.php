<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ruangans';

    protected $fillable = [
        'nama',
        'cabang_id',
        'kode',
        'deskripsi',
        'kapasitas',
        'status',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function isNonaktif(): bool
    {
        return $this->status === 'nonaktif';
    }

    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }
}
