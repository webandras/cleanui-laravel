<?php

namespace Database\Seeders\Event;

use App\Models\Clean\Permission;
use Illuminate\Database\Seeder;

class EventModulePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manageEvents       = new Permission();
        $manageEvents->name = 'Manage Events';
        $manageEvents->slug = 'manage-events';
        $manageEvents->save();

        $manageLocations     = new Permission();
        $manageLocations->name = 'Manage Locations';
        $manageLocations->slug = 'manage-locations';
        $manageLocations->save();

        $manageOrgs    = new Permission();
        $manageOrgs->name = 'Manage Organizers';
        $manageOrgs->slug = 'manage-organizers';
        $manageOrgs->save();
    }
}
