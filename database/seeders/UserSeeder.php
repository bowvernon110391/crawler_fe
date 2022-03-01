<?php

namespace Database\Seeders;

use App\Models\SSO\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed 50 users
        $numSeed = 50;
        echo "Seeding {$numSeed} users...\n";
        
        User::factory()->count($numSeed)->create();

        // echo "Done Seeding users.\n";
    }
}
