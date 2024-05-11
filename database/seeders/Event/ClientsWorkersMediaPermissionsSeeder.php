<?php

namespace Database\Seeders\Event;

use App\Models\Clean\Permission;
use Database\Seeders\Traits\HasRolesPermissionsGetters;
use Illuminate\Database\Seeder;

class ClientsWorkersMediaPermissionsSeeder extends Seeder
{
    use HasRolesPermissionsGetters;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manageClients      = new Permission();
        $manageClients->name = 'Manage Clients';
        $manageClients->slug = 'manage-clients';
        $manageClients->save();

        $manageWorkers       = new Permission();
        $manageWorkers->name = 'Manage Workers';
        $manageWorkers->slug = 'manage-workers';
        $manageWorkers->save();

        $manageMedia      = new Permission();
        $manageMedia->name = 'Manage Media';
        $manageMedia->slug = 'manage-media';
        $manageMedia->save();



        $newPermissions = [$manageClients->id, $manageWorkers->id, $manageMedia->id];

        // Add permissions to the superadmin
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->attach($newPermissions);


        // Add permissions to the admin
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->attach($newPermissions);
    }
}
