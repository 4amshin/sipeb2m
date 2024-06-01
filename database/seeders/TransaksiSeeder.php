<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksis')->insert([
            [
                'nama_penyewa' => 'Ibrahim',
                'alamat_penyewa' => 'Bua',
                'noTelepon_penyewa' =>  '081231341561',
                'kode_transaksi' => Str::random(10),
                'tanggal_sewa' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'harga_total' => 250000.00,
                'status' =>  'diproses',
            ],
            [
                'nama_penyewa' => 'Siti Fatimah',
                'alamat_penyewa' => 'Luwu Timu',
                'noTelepon_penyewa' =>  '081231341561',
                'kode_transaksi' => Str::random(10),
                'tanggal_sewa' => now(),
                'tanggal_kembali' => now()->addDays(7),
                'harga_total' => 350000.00,
                'status' =>  'diproses',
            ],
        ]);
    }
}
