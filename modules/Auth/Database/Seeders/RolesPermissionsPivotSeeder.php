<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auth\Traits\HasRolesPermissionsGetters;

class RolesPermissionsPivotSeeder extends Seeder
{
    use HasRolesPermissionsGetters;


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permission ids
        $users = $this->getPermissionBySlug('manage-users')->id;
        $account = $this->getPermissionBySlug('manage-account')->id;
        $roles = $this->getPermissionBySlug('manage-roles')->id;
        $permissions = $this->getPermissionBySlug('manage-permissions')->id;

        // Add permissions to the super-administrator
        $admin = $this->getRoleBySlug('super-administrator');
        $admin->permissions()->sync([$account, $users, $roles, $permissions]);

        // Add permissions to the administrator
        $admin2 = $this->getRoleBySlug('administrator');
        $admin2->permissions()->sync([$account]);

        // Add permissions to the customer
        $customer = $this->getRoleBySlug('customer');
        $customer->permissions()->sync([$account]);
    }
}
