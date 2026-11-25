<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@galeri.test'],
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@galeri.test'],
            [
                'username' => 'user',
                'name' => 'Siswa Contoh',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
            ]
        );
    }
}
