<?php
namespace App\Trait\Clean;

use App\Models\Clean\Role;
use App\Models\Clean\User;

trait UserPermissions
{

    private function getUserPermissions(?User $user = null): array
    {
        $userRoleWithPermissions = Role::where('slug', Auth()->user()->role->slug)
                                       ->with('permissions')
                                       ->first();

        return $userRoleWithPermissions->permissions
            ->pluck('slug')
            ->toArray();
    }


}
