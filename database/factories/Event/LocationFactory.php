<?php

namespace Database\Factories\Event;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Event\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->words(3, true),
            'address'   => $this->faker->address(),
            'city'      => $this->faker->city(),
            'slug'      => $this->faker->slug,
            'latitude'      => $this->faker->latitude(35,50),
            'longitude'      => $this->faker->longitude(-10, 25),
        ];
    }
}
