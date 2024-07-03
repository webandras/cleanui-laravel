<?php

namespace Modules\Event\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Clean\Interfaces\SeederInterface;
use Modules\Event\Models\Organizer;

class OrganizerSeeder extends Seeder  implements SeederInterface
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organizer::factory(self::DEFAULT_MAX)->create();
    }
}
