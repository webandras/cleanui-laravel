<?php

namespace Modules\Event\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Clean\Interfaces\SeederInterface;
use Modules\Event\Models\Event;

class EventSeeder extends Seeder implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::factory(self::DEFAULT_MAX)->create();
    }
}
