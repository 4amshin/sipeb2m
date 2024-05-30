<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Sipeb2m',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Palopo Kota',
            'role' => 'admin',
            'email' => 'admin@sipeb2m.id',
            'unHashed_password' => 'password',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'name' => 'Ibrahim',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Bua',
            'role' => 'pengguna',
            'email' => 'ibrahim@sipeb2m.id',
            'unHashed_password' => 'password',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'name' => 'Siti Fatimah',
            'nomor_telepon' =>  '081231341561',
            'alamat' => 'Luwu Timu',
            'role' => 'pengguna',
            'email' => 'siti@sipeb2m.id',
            'unHashed_password' => 'password',
            'password' => Hash::make('password'),
        ]);
    }
}
