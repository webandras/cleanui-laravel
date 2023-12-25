<?php

namespace Database\Seeders;

use App\Interface\SeederInterface;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder  implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory(self::DEFAULT_MAX)->create();
    }
}
