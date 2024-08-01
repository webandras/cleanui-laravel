<?php

namespace Modules\Event\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Event\Models\Location;

class LocationSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::factory(self::MAX)->create();
    }
}
