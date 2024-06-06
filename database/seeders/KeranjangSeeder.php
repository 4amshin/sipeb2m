<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('keranjangs')->insert([
            [
                'pengguna_id'  => 2,
                'baju_id' => 1,
                'jumlah' => 2,
                'harga_sewa_perhari'  => 50000,
            ],
            [
                'pengguna_id'  => 2,
                'baju_id' => 2,
                'jumlah' => 3,
                'harga_sewa_perhari'  => 55000,
            ],
            [
                'pengguna_id'  => 3,
                'baju_id' => 3,
                'jumlah' => 5,
                'harga_sewa_perhari'  => 45000,
            ],
        ]);
    }
}
