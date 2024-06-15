<?php

namespace Database\Seeders\Event;

use App\Interface\Clean\SeederInterface;
use Illuminate\Database\Seeder;
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
