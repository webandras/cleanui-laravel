<?php

namespace Database\Seeders\Event;

use App\Interface\Clean\SeederInterface;
use Illuminate\Database\Seeder;
use Modules\Event\Models\Location;

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
