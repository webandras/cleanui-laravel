<?php

namespace Database\Seeders\Clean;

use Illuminate\Database\Seeder;
use Modules\Clean\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(3)
            ->create()
            ->each(function ($category) {
                Category::factory(rand(1, 3))->create(
                    [
                        'category_id' => $category->id,
                    ]
                )
                    ->each(function ($subcategory) {
                        Category::factory(rand(1, 3))->create(
                            [
                                'category_id' => $subcategory->id,
                            ]
                        );
                    });
            });
    }
}
