<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Claims;
use App\Models\User;
use App\Models\Policy;
use Illuminate\Support\Carbon;

class ClaimsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Grab a test user and policy (assumes they already exist)
        $user = User::where('email', 'cammy@gmail.com')->first();
        $policy = Policy::first();

        if ($user && $policy) {
            Claims::create([
                'user_id' => $user->id,
                'policy_id' => $policy->Policy_ID,
                'description' => 'Medical expenses due to an accident.',
                'status' => 'Pending',
                'date_submitted' => Carbon::now()->subDays(2),
            ]);

            Claims::create([
                'user_id' => $user->id,
                'policy_id' => $policy->Policy_ID,
                'description' => 'Vehicle damage claim after storm.',
                'status' => 'Approved',
                'date_submitted' => Carbon::now()->subDays(7),
            ]);

            Claims::create([
                'user_id' => $user->id,
                'policy_id' => $policy->Policy_ID,
                'description' => 'Property theft during travel.',
                'status' => 'Rejected',
                'date_submitted' => Carbon::now()->subDays(10),
            ]);
        } else {
            echo "User or policy not found. Seeder aborted.\n";
        }
    }
}
