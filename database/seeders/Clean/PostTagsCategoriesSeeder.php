<?php

namespace Database\Seeders\Clean;

use App\Interface\Clean\SeederInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagsCategoriesSeeder extends Seeder implements SeederInterface
{
    private function getRandomIds(): array
    {
        $numbers = [];
        $i = 1;
        $maxIterations = rand(1, 3);

        while ($i <= $maxIterations) {
            $randomNumber = rand(1, 10);
            if (!in_array($randomNumber, $numbers)) {
                $numbers[] = $randomNumber;
                $i++;
            }
        }

        return $numbers;
    }


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = new \Faker\Generator();

        DB::transaction(function () use ($faker) {

            for ($postId = 1; $postId <= self::DEFAULT_MAX; $postId++) {
                $tags = $this->getRandomIds();

                foreach ($tags as $tag) {
                    DB::table('posts_tags')->insert([
                        'post_id' => $postId,
                        'tag_id' => $tag
                    ]);
                }
            }

            for ($postId = 1; $postId <= self::DEFAULT_MAX; $postId++) {
                $categories = $this->getRandomIds();

                foreach ($categories as $category) {
                    DB::table('posts_categories')->insert([
                        'post_id' => $postId,
                        'category_id' => $category
                    ]);
                }
            }

        });


    }
}
