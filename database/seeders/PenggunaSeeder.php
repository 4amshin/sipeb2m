<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::factory()->create([
            'nama' => 'Admin Sipeb2m',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Palopo Kota',
            'role' => 'admin',
            'email' => 'admin@sipeb2m.id',
            'password' => 'password',
        ]);
        Pengguna::factory()->create([
            'nama' => 'Ibrahim',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Bua',
            'role' => 'pengguna',
            'email' => 'ibrahim@sipeb2m.id',
            'password' => 'password',
        ]);
        Pengguna::factory()->create([
            'nama' => 'Siti Fatimah',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Luwu Timu',
            'role' => 'pengguna',
            'email' => 'siti@sipeb2m.id',
            'password' => 'password',
        ]);

        // Tambahkan 10 data dummy
        // Pengguna::factory()->count(10)->create();
    }
}
