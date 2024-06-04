<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengembalianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengembalians')->insert([
            [
                'transaksi_id'  => 1,
                'status' => 'belum_diKembalikan',
            ],
            [
                'transaksi_id'  => 2,
                'status' => 'diKembalikan',
            ],
        ]);
    }
}
