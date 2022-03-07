<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CrawlingJob;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'crawling_job_id' => optional(CrawlingJob::inRandomOrder()->first())->id,
            'item_id' => random_int(3332, PHP_INT_MAX/10),
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'image_url' => $this->faker->imageUrl,
            'rating' => random_int(1, 5),
            'rating_avg' => $this->faker->randomFloat(2, 1, 5),
            'price' => $this->faker->randomNumber(5),
            'view_count' => random_int(0, 1000),
            'wishlist_count' => random_int(0, 1000),
            'category_id' => optional(Category::inRandomOrder()->first())->id,
            'shop_id' => optional(Shop::inRandomOrder()->first())->id
        ];
    }
}
