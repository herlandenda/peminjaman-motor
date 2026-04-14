<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin DOD',
            'email' => 'admin@gmail.com', // Ini email untuk login
            'password' => Hash::make('rahasia123'), // Ini password untuk login
        ]);
    }
}