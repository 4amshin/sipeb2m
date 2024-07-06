<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('detail_transaksis')->insert([
            [
                'transaksi_id' => 1,
                'baju_id' => 1,
                'ukuran' => 'M',
                'jumlah' => 5,
            ],
            [
                'transaksi_id' => 2,
                'baju_id' => 2,
                'ukuran' => 'L',
                'jumlah' => 5,
            ],
            [
                'transaksi_id' => 2,
                'baju_id' => 3,
                'ukuran' => 'S',
                'jumlah' => 1,
            ],
        ]);
    }
}
