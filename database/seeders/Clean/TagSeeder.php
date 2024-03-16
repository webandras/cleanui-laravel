<?php

namespace Database\Seeders\Clean;

use App\Interface\Utils\Clean\SeederInterface;
use App\Models\Clean\Tag;
use Illuminate\Database\Seeder;

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
