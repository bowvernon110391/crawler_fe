<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = random_int(10, 50);
        echo "Seeding {$num} Shops...\n";
        Shop::factory()->count($num)->create();
    }
}
