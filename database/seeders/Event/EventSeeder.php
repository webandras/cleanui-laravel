<?php

namespace Database\Seeders\Event;

use App\Interface\Clean\SeederInterface;
use Illuminate\Database\Seeder;
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
