<?php

namespace Database\Seeders\Clean;

use Illuminate\Database\Seeder;
use Modules\Clean\Models\Document;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Document::factory(1)->create([
                'order' => $i,
            ]);
        }

    }
}
