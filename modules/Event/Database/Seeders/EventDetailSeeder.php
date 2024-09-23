<?php

namespace Modules\Event\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Event\Models\EventDetail;

class EventDetailSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            for ($i = 1; $i <= self::MAX; $i++) {
                EventDetail::factory()->create([
                    'event_id' => $i
                ]);
            }
        }, 1);

    }
}
