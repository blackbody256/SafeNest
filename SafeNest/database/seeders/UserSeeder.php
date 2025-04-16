<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {//just testing if the roles work 
        User::create([
            'name' => 'Treasure',
            'email' => 'Treasure@gmail.com',
            'password' => Hash::make('treasure'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Humpho',
            'email' => 'humphojunior@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'underwriter',
        ]);

        User::create([
            'name' => 'Cammy',
            'email' => 'cammy@gmail.com',
            'password' => Hash::make('cammy'),
            'role' => 'customer',
        ]);
        
    }
}
