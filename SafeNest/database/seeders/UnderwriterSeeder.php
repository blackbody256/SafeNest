<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Underwriter;
use App\Models\User;

class UnderwriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Find all users with underwriter role
    $underwriterUsers = User::where('role', 'underwriter')->get();
    
    // Create underwriter records for each user with underwriter role
    foreach ($underwriterUsers as $user) {
        // Check if an underwriter record already exists for this user
        if (!Underwriter::where('user_id', $user->id)->exists()) {
            Underwriter::create([
                'user_id' => $user->id,
                'commission_rate' => 5.00, // Default rate
            ]);
        }
    }
}
}
