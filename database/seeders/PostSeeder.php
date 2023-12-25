<?php

namespace Database\Seeders;

use App\Interface\SeederInterface;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
