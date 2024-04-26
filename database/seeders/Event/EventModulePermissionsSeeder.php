<?php

namespace Database\Seeders\Event;

use App\Models\Clean\Permission;
use Database\Seeders\Traits\HasRolesPermissionsGetters;
use Illuminate\Database\Seeder;

class EventModulePermissionsSeeder extends Seeder
{
    use HasRolesPermissionsGetters;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manageEvents       = new Permission();
        $manageEvents->name = 'Manage Events';
        $manageEvents->slug = 'manage-events';
        $manageEvents->save();

        $manageLocations       = new Permission();
        $manageLocations->name = 'Manage Locations';
        $manageLocations->slug = 'manage-locations';
        $manageLocations->save();

        $manageOrgs       = new Permission();
        $manageOrgs->name = 'Manage Organizers';
        $manageOrgs->slug = 'manage-organizers';
        $manageOrgs->save();


        $newPermissions = [$manageEvents->id, $manageLocations->id, $manageOrgs->id];

        // Add permissions to the superadmin
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->attach($newPermissions);


        // Add permissions to the admin
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->attach($newPermissions);
    }
}
