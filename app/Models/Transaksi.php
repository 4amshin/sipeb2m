<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengguna_id',
        'kode_transaksi',
        'tanggal_sewa',
        'tanggal_kembali',
        'harga_total',
        'status',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id');
    }
}
