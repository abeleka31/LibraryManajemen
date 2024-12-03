<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin31@gmail.com',
            'image' => null,
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('admin310305'), 
            'remember_token' => Str::random(10),
        ]);


    }
}
