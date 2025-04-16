<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payments;
use App\Models\User;
use App\Models\Policy;
use Carbon\Carbon;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id')->toArray();
        $policies = Policy::pluck('Policy_ID')->toArray(); // adjust if your PK is different

        if (empty($users) || empty($policies)) {
            $this->command->warn('No users or policies found. Please seed users and policies first.');
            return;
        }

        foreach (range(1, 10) as $i) {
            $createdAt = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 12));
            $updatedAt = $createdAt->copy()->addHours(rand(1, 5));

            Payments::create([
                'user_id' => $users[array_rand($users)],
                'policy_id' => $policies[array_rand($policies)],
                'amount' => rand(100, 1000) + 0.99,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }
    }
}
