<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('policies')->insert([
            [
                'Title' => 'Health Insurance',
                'Description' => 'Provides coverage for medical expenses.',
                'Premium' => '5000',
                'Duration' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Title' => 'Car Insurance',
                'Description' => 'Covers damages to your vehicle in case of an accident.',
                'Premium' => '3000',
                'Duration' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Title' => 'Home Insurance',
                'Description' => 'Protects your home against natural disasters and accidents.',
                'Premium' => '4000',
                'Duration' => 24,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Title' => 'Life Insurance',
                'Description' => 'Provides financial support to your family in the event of death.',
                'Premium' => '7000',
                'Duration' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
