<?php

namespace Database\Factories\Clean;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Clean\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => $this->faker->words(3, true),
            'slug'            => $this->faker->slug,
            'cover_image_url' => '/images/img_forest.jpg',
        ];
    }
}
