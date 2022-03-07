<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = random_int(10, 30);
        echo "Seeding {$num} Tags...\n";
        Tag::factory()->count($num)->create();
    }
}
