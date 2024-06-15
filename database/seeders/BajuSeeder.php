<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BajuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bajus')->insert([
            [
                'nama_baju' => 'Baju Bodo Merah',
                'ukuran' => 'M',
                'stok' => 10,
                'harga_sewa_perhari' => 50000.00,
            ],
            [
                'nama_baju' => 'Baju Bodo Hijau',
                'ukuran' => 'L',
                'stok' => 8,
                'harga_sewa_perhari' => 55000.00,
            ],
            [
                'nama_baju' => 'Baju Bodo Biru',
                'ukuran' => 'S',
                'stok' => 15,
                'harga_sewa_perhari' => 45000.00,
            ],
            [
                'nama_baju' => 'Baju Bodo Kuning',
                'ukuran' => 'XL',
                'stok' => 5,
                'harga_sewa_perhari' => 60000.00,
            ],
        ]);
    }
}
