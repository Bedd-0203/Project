<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::create([
            'name' => 'Admin Portal SDA',
            'email' => 'admin@sda.palembang.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // PETUGAS
        User::create([
            'name' => 'Petugas Lapangan',
            'email' => 'petugas@sda.palembang.go.id',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas'
        ]);

        // MASYARAKAT
        User::create([
            'name' => 'User Masyarakat',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'masyarakat'
        ]);
    }
}