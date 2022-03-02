<?php

namespace Database\Factories;

use App\Models\CrawlingJob;
use App\Models\SSO\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrawlingJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $prods = [];
        for ($i=0; $i<random_int(8, 10); $i++) {
            $prods[] = $this->faker->company;
        }

        return [
            // some fake data for crawling job?
            'name' => $this->faker->words(random_int(1,3), true),
            'keyword_data' => implode(';',$this->faker->randomElements($prods, $this->faker->numberBetween(1, 8))),
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement([CrawlingJob::CREATED, CrawlingJob::PROCESSING, CrawlingJob::DONE]),
            'private' => $this->faker->boolean(70)
        ];
    }
}
