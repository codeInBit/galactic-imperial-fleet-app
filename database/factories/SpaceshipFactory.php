<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpaceshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'class' => $this->faker->name(),
            'crew' => $this->faker->randomNumber(5, false),
            'image' => $this->faker->imageUrl($width = 200, $height = 200),
            'value' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->word(),
        ];
    }
}
