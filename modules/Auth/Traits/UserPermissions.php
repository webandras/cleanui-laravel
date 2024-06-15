<?php
namespace Modules\Auth\Traits;

use Modules\Auth\Models\User;
use Modules\Clean\Models\Role;

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
