<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\SeederInterface;

class TagSeeder extends Seeder implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(self::DEFAULT_MAX)->create();
    }
}
