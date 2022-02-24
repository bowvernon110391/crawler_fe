<?php

namespace Database\Factories\SSO;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'group' => $this->faker->randomElement(['beacukai', 'pemda']),
            'status' => $this->faker->randomElement(['enabled', 'disabled']),
            'last_token' => $this->faker->bothify('#?#?#?#?#?##?##?#-##?#?#-##??#?'),
            'nama' => $this->faker->name,
            'nip' => $this->faker->numerify('19##201210#00#'),
            'kantor' => $this->faker->company,
            'kantor_id' => $this->faker->postcode,
            'kantor_level' => $this->faker->randomElement(['es2', 'es3', 'propinsi', 'kota_kab']),
            'kode_eselon2' => $this->faker->postcode,
            'eselon2' => $this->faker->company,

            // role string, pick between 3
            'role' => implode(
                ',',
                $this->faker->randomElements(['administrator','user'], $this->faker->numberBetween(1,2))
            )
        ];
    }
}
