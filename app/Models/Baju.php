<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baju extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_baju',
        'gambar_baju',
        'ukuran',
        'stok',
        'harga_sewa_perhari',
        'deskripsi',
        'is_available',
    ];
}
