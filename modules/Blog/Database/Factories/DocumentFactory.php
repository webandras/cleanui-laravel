<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Blog\Enum\PostStatus;
use Modules\Blog\Models\Document;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Blog\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Document::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'           => $this->faker->words(6, true),
            'slug'            => $this->faker->slug(),
            'excerpt'         => $this->faker->text(255),
            'content'         => $this->faker->randomHtml(),
            'status'          => $this->faker->randomElement(PostStatus::values()),
            'order'           => 0,
        ];
    }
}
