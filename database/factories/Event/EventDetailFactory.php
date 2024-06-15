<?php

namespace Database\Factories\Event;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Event\Models\EventDetail>
 */
class EventDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imagePaths = [
            '/images/img_forest.jpg',
            '/images/img_lights.jpg',
            '/images/img_mountains.jpg',
            '/images/img_snowtops.jpg',
            '/images/placeholder.png'
        ];

        return [
            'event_id' => 1,
            'cover_image_url' => $this->faker->randomElement($imagePaths),
            'facebook_url' => $this->faker->url(),
            'tickets_url' => $this->faker->url(),
        ];
    }
}
