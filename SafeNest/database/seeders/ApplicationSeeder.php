<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Policy;
use Illuminate\Support\Carbon;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'cammy@gmail.com')->first();
        $policy = Policy::first();

        if ($user && $policy) {
            Application::create([
                'User_ID' => $user->id,
                'Policy_ID' => $policy->Policy_ID,
                'Status' => 'Approved',
                'Date_Applied' => Carbon::now()->subDays(3)->toDateString(),
            ]);

            Application::create([
                'User_ID' => $user->id,
                'Policy_ID' => $policy->Policy_ID,
                'Status' => 'Pending',
                'Date_Applied' => Carbon::now()->toDateString(),
            ]);

            Application::create([
                'User_ID' => $user->id,
                'Policy_ID' => $policy->Policy_ID,
                'Status' => 'Rejected',
                'Date_Applied' => Carbon::now()->subDays(5)->toDateString(),
            ]);
            Application::create([
                'User_ID' => $user->id,
                'Policy_ID' => $policy->Policy_ID,
                'Status' => 'Approved',
                'Date_Applied' => Carbon::now()->subDays(10)->toDateString(),
            ]);
        }
    }
}
