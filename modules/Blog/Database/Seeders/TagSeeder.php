<?php

namespace Modules\Blog\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Blog\Models\Tag;

class TagSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(self::MAX)->create();
    }
}
