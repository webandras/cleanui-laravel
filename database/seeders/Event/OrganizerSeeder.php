<?php

namespace Database\Seeders\Event;

use App\Interface\Utils\Clean\SeederInterface;
use App\Models\Event\Organizer;
use Illuminate\Database\Seeder;

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
