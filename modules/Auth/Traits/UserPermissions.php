<?php
namespace Modules\Auth\Traits;

use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;

trait UserPermissions
{

    /**
     * @param  User|null  $user
     * @return array
     */
    private function getUserPermissions(?User $user = null): array
    {
        $userRoleWithPermissions = Role::where('slug', Auth()->user()->role->slug)->with('permissions')->first();

        return $userRoleWithPermissions->permissions
            ->pluck('slug')
            ->toArray();
    }


}
