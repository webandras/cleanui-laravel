<?php

namespace Modules\Blog\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Blog\Models\Document;

class DocumentSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= self::MAX; $i++) {
            Document::factory(1)->create([
                'order' => $i,
            ]);
        }

    }
}
