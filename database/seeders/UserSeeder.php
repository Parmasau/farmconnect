<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@farmconnect.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Demo Farmer',
            'email'    => 'farmer@farmconnect.com',
            'password' => Hash::make('password'),
            'role'     => 'farmer',
        ]);

        User::create([
            'name'     => 'Demo Agrovet',
            'email'    => 'agrovet@farmconnect.com',
            'password' => Hash::make('password'),
            'role'     => 'agrovet',
        ]);
    }
}
