<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'nomor_telepon',
        'alamat',
        'role',
        'gambar_profil',
        'email',
        'password',
    ];
}
