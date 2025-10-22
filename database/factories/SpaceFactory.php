<?php

namespace Database\Factories;

use App\Models\Space;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Space>
 */
class SpaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->address,
            'city' => fake()->city,
            'postcode' => fake()->postcode,
            'rate' => fake()->numberBetween(1, 10),
            'category' => fake()->randomElement(Space::$category),
            'ev' => fake()->randomElement(Space::$ev)
        ];
    }
}
