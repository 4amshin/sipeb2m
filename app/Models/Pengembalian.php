<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'status',
        'tanggal_kembali',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
