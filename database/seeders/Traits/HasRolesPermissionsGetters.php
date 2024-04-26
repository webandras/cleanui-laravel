<?php

namespace Database\Seeders\Traits;

use App\Models\Clean\Permission;
use App\Models\Clean\Role;

trait HasRolesPermissionsGetters
{
    /**
     * Get the permission entity by the slug value
     *
     * @param  string  $slug
     *
     * @return Permission|null
     */
    protected function getPermissionBySlug(string $slug): ?Permission
    {
        return Permission::where('slug', $slug)->firstOrFail();
    }


    /**
     * Get the role entity by the slug value
     *
     * @param  string  $slug
     *
     * @return Role|null
     */
    protected function getRoleBySlug(string $slug): ?Role
    {
        return Role::where('slug', $slug)->firstOrFail();
    }

}
