<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh data pengguna
        User::create([
            'name' => 'Admin User',
            'email' => 'admin31@gmail.com',
            'image' => null,
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin3103'), // Enkripsi password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Mahasiswa User',
            'email' => 'mahasiswa31@gmail.com',
            'image' => null,
            'role' => 'mahasiswa',
            'email_verified_at' => now(),
            'password' => Hash::make('mahasiswa31'),
            'remember_token' => Str::random(10),
        ]);
    }
}
