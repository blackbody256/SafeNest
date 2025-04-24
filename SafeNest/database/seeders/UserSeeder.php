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

        
        
    }
}
