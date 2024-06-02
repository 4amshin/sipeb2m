<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaksi_id',
        'pembayaran_masuk',
        'status_pembayaran',
        'metode_pembayaran',
        'tanggal_pembayaran',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
