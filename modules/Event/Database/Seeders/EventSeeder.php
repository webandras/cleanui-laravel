<?php

namespace Modules\Event\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Event\Models\Event;

class EventSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory(self::MAX)->create();
    }
}
