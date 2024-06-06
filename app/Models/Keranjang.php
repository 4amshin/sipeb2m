<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'baju_id',
        'jumlah',
        'harga_sewa_perhari',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function baju()
    {
        return $this->belongsTo(Baju::class);
    }
}
