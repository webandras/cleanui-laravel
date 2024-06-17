<?php

namespace Database\Factories\Clean;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Clean\Models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Clean\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Tag::class;


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
