<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengguna>
 */
class PenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'nomor_telepon' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'role' => 'pengguna',
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password
        ];
    }
}
