<?php

namespace Modules\Blog\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Blog\Models\Post;

class PostSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(self::MAX - 2)->create([
            'status' => 'published'
        ]);
        Post::factory(1)->create([
            'status' => 'draft'
        ]);
        Post::factory(1)->create([
            'status' => 'under-review'
        ]);
    }
}
