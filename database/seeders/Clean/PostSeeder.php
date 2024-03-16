<?php

namespace Database\Seeders\Clean;

use App\Interface\Utils\Clean\SeederInterface;
use App\Models\Clean\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(8)->create();
        Post::factory(1)->create([
            'status' => 'draft'
        ]);
        Post::factory(1)->create([
            'status' => 'under-review'
        ]);
    }
}
