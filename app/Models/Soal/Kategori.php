<?php

namespace App\Models\Soal;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
        'deskripsi'
    ];

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }
}
