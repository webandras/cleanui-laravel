<?php

namespace Modules\Event\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Event\Models\EventDetail;

class EventDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10] as $id) {
                EventDetail::factory()->create([
                    'event_id' => $id
                ]);
            }
        }, 1);

    }
}
