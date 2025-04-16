<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Policy;
use Illuminate\Support\Carbon;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Seeder is running...\n";
        Policy::create([
            'Title' => 'Basic Health Cover',
            'Description' => 'Covers outpatient and inpatient services.',
            'Premium' => '150,000 UGX',
            'Duration' => Carbon::now()->addYear()->toDateString(), // 1 year from now
        ]);

        Policy::create([
            'Title' => 'Car Insurance',
            'Description' => 'Protects against vehicle damages and theft.',
            'Premium' => '250,000 UGX',
            'Duration' => Carbon::now()->addMonths(6)->toDateString(), // 6 months from now
        ]);

        Policy::create([
            'Title' => 'Home Insurance',
            'Description' => 'Covers damages to home and personal belongings.',
            'Premium' => '300,000 UGX',
            'Duration' => Carbon::now()->addMonths(12)->toDateString(), // 1 year from now
        ]);
    }
}
