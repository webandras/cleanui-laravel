<?php

namespace Modules\Event\Database\Seeders;

use App\Traits\SeederTrait;
use Illuminate\Database\Seeder;
use Modules\Event\Models\Organizer;

class OrganizerSeeder extends Seeder
{
    use SeederTrait;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organizer::factory(self::MAX)->create();
    }
}
