<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Underwriter;
use Illuminate\Support\Facades\Hash;

class UnderwriterSeeder extends Seeder
{
    public function run(): void
    {
        // Create a user with role 'underwriter'
        $user = User::create([
            'name' => 'Jane Underwriter',
            'email' => 'underwriter@example.com',
            'password' => Hash::make('password123'),
            'role' => 'underwriter',
        ]);

        // Create their corresponding underwriter profile
        Underwriter::create([
            'user_id' => $user->id,
            'commission_rate' => 7.5,
        ]);
    }
}
