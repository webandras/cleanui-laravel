<?php

namespace Modules\Job\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Models\Permission;
use Modules\Auth\Traits\HasRolesPermissionsGetters;

class JobModulePermissionsSeeder extends Seeder
{
    use HasRolesPermissionsGetters;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $manageJobs       = new Permission();
        $manageJobs->name = 'Manage Jobs';
        $manageJobs->slug = 'manage-jobs';
        $manageJobs->save();

        $manageClients      = new Permission();
        $manageClients->name = 'Manage Clients';
        $manageClients->slug = 'manage-clients';
        $manageClients->save();

        $manageWorkers       = new Permission();
        $manageWorkers->name = 'Manage Workers';
        $manageWorkers->slug = 'manage-workers';
        $manageWorkers->save();

        $newPermissions = [$manageJobs->id, $manageClients->id, $manageWorkers->id];

        // Add permissions to the super-administrator
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->attach($newPermissions);

        // Add permissions to the administrator
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->attach($newPermissions);
    }
}
