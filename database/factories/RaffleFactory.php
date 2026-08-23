<?php

namespace Database\Factories;

use App\Models\Raffle;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Raffle>
 */
class RaffleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'published_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', '+1 year')
        ];
    }
}
