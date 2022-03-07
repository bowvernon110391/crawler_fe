<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shop_id' => random_int(20032, PHP_INT_MAX/2),
            'name' => $this->faker->words(random_int(1, 3), true),
            'url' => $this->faker->url,
            'domain' => $this->faker->domainName,
            'kota' => $this->faker->city,
            'alamat' => $this->faker->address,
            'kode_pos' => $this->faker->postcode,
            'lat' => $this->faker->latitude,
            'lon' => $this->faker->longitude,
            'last_active' => $this->faker->dateTime('now', 'Asia/Jakarta'),
            'registered_at' => $this->faker->dateTime('now', 'Asia/Jakarta'),
            'marketplace' => 'tokopedia'
        ];
    }
}
