<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = random_int(30, 60);
        echo "Seeding {$num} Items...\n";
        // first, seed as usual
        $items = Item::factory()->count($num)->create();

        // then, for each of them, assign some tags
    }
}
