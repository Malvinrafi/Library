<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User biasa
        User::factory()->create([
            'name' => 'Malvin',
            'email' => 'malvin@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Admin
        User::factory()->create([
            'name' => 'AdminPerpus',
            'email' => 'perpusadmin@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
