<?php

namespace Database\Seeders\Event;

use App\Interface\Utils\Clean\SeederInterface;
use App\Models\Event\Event;
use Illuminate\Database\Seeder;

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
