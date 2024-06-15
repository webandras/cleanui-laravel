<?php

namespace Database\Seeders\Clean;

use App\Interface\Clean\SeederInterface;
use Illuminate\Database\Seeder;
use Modules\Clean\Models\Tag;

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
