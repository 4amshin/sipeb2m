<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembayarans')->insert([
            [
                'transaksi_id' => 1,
                'pembayaran_masuk' => 100000,
                'status_pembayaran' => 'belum_lunas',
                'metode_pembayaran' => 'Tunai',
                'tanggal_pembayaran' => now(),
            ],
            [
                'transaksi_id' => 2,
                'pembayaran_masuk' => 150000,
                'status_pembayaran' => 'belum_lunas',
                'metode_pembayaran' => 'Transfer Bank',
                'tanggal_pembayaran' => now(),
            ],
        ]);
    }
}
