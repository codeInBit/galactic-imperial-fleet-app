<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArmamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'spaceship_id' => function () {
                return factory(\App\Models\Spaceship::class)->create()->id;
            },
            'title' => $this->faker->name(),
            'qty' => $this->faker->randomNumber(3, false),
        ];
    }
}
