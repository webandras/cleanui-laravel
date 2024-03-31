<?php

namespace Database\Seeders\Event;

use App\Interface\Utils\Clean\SeederInterface;
use App\Models\Event\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::factory(self::DEFAULT_MAX)->create();
    }
}
