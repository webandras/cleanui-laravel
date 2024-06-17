<?php

namespace Database\Factories\Event;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Event\Models\Organizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Event\Models\Organizer>
 */
class OrganizerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Organizer::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'facebook_url' => $this->faker->url
        ];
    }
}
