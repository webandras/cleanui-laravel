<?php

namespace Database\Factories\Clean;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Clean\Models\Document;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Clean\Models\Document>
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
            'title'           => $this->faker->words(3, true),
            'slug'            => $this->faker->slug(),
            'excerpt'         => $this->faker->text(255),
            'content'         => $this->faker->randomHtml(),
            'status'          => 'published',
            'order'         => 0,
        ];
    }
}
