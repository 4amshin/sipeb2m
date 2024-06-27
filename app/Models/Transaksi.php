<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'nama_penyewa',
        'alamat_penyewa',
        'noTelepon_penyewa',
        'tanggal_sewa',
        'tanggal_kembali',
        'harga_total',
        'status_order',
        'status_sewa',
    ];


    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id', 'id');
    }
}
