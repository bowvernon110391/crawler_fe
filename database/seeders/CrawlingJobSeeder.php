<?php

namespace Database\Seeders;

use App\Models\CrawlingJob;
use Illuminate\Database\Seeder;

class CrawlingJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // seed some jobs
        $num = 30;
        echo "Seeding {$num} CrawlingJob(s)...\n";
        CrawlingJob::factory()->count($num)->create();
    }
}
