<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed some categories?
        $num = random_int(10, 30);
        echo "Seeding {$num} categories...\n";
        Category::factory()->count($num)->create();
    }
}
