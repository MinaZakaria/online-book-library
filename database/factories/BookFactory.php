<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->regexify('/Book [0-9]{2}/'),
            'author' => $this->faker->name(),
            'category_id' => $this->faker->numberBetween(1, 5),
        ];
    }
}
