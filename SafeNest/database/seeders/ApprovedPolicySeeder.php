<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApprovedPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Cammy and Sunny Cheeks
        $users = DB::table('users')
            ->whereIn('name', ['Cammy', 'Sunny Cheeks'])
            ->pluck('id', 'name');

        // Get all policies
        $policies = DB::table('policies')->pluck('Policy_ID');

        foreach ($users as $name => $userId) {
            foreach ($policies as $policyId) {
                DB::table('approved_policies')->insert([
                    'User_ID' => $userId,
                    'Policy_ID' => $policyId,
                    'Status' => 'active',
                    'expires_at' => fake()->optional()->dateTimeBetween('+3 months', '+1 year'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "✅ Approved policies seeded for Cammy & Sunny Cheeks!\n";
    }
}
