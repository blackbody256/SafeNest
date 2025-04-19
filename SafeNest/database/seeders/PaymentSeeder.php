<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get approved policies
        $approvedPolicies = DB::table('approved_policies')->get();
        $policies = DB::table('policies')->pluck('Policy_ID');

        foreach ($approvedPolicies as $approved) {
            // Random number of payments per policy (between 1 and 3)
            $numPayments = rand(1, 3);

            for ($i = 0; $i < $numPayments; $i++) {
                $status = collect(['paid', 'pending', 'overdue'])->random();
                $dueDate = now()->addDays(rand(-30, 30)); // due date can be in past/future
                $paymentDate = $status === 'paid' ? now()->subDays(rand(1, 15)) : null;

                DB::table('payments')->insert([
                    'user_id' => $approved->User_ID,
                    'policy_id' => $policies ->random(),
                    'approved_policy_id' => $approved->Approved_Policy_ID,
                    'amount' => rand(1000, 10000),
                    'due_date' => $dueDate,
                    'payment_date' => $paymentDate,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "💰 Payments seeded for approved policies!\n";
    }
}
