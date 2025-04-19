<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PolicyApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch only Cammy and Sunny Cheeks
        $users = DB::table('users')
            ->whereIn('name', ['Cammy', 'Sunny Cheeks'])
            ->pluck('id', 'name');

        // Get all policies
        $policies = DB::table('policies')->pluck('Policy_ID');

        // Optional statuses for fun
        $statuses = ['pending', 'approved', 'rejected'];

        foreach ($users as $name => $userId) {
            foreach ($policies as $policyId) {
                DB::table('policy_applications')->insert([
                    'User_ID' => $userId,
                    'Policy_ID' => $policyId,
                    'Status' => collect($statuses)->random(),
                    'Requirements_path' => null,
                    'notes' => fake()->optional()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "🎉 Policy applications seeded for Cammy & Sunny Cheeks!\n";
    }
}
