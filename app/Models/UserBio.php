<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    /** @use HasFactory<\Database\Factories\UserBioFactory> */
    use HasFactory;

    protected $table = 'user_bios';
}
