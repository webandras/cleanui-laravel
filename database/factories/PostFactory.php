<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
        ];


        return [
            'title'           => $this->faker->words(3, true),
            'status'          => 'published',
            'slug'            => $this->faker->slug(),
            'content'         => $this->faker->randomHtml(),
            'excerpt'         => $this->faker->realText(),
            'is_highlighted'  => $this->faker->numberBetween(0, 1),
            'cover_image_url' => $this->faker->randomElement($imagePaths),
        ];
    }
}
