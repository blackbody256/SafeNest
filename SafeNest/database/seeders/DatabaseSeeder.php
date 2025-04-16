<?php
namespace Database\Seeders;

use App\Models\Underwriter;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class, 
            
            
            UsersTableSeeder::class,
            
    ]);
    }
}
