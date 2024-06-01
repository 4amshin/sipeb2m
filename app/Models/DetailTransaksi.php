<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaksi_id',
        'baju_id',
        'ukuran',
        'jumlah',
    ];


    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function baju()
    {
        return $this->belongsTo(Baju::class);
    }
}
