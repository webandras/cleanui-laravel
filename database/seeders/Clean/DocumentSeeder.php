<?php

namespace Database\Seeders\Clean;

use App\Models\Clean\Document;
use Illuminate\Database\Seeder;

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
