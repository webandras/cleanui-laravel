<?php

namespace Tests;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;


class UserTest extends TestCase
{
    protected function assert_if_route_can_be_accessed(string $path = '/admin/user/manage'): void
	{
        $response = $this->get($path);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertStatus(200);
    }


    protected function assert_if_user_has_permission_to_routes(User $user, Role|Builder|Model $role): void
	{
        DB::transaction(function () use ($user, $role) {
            foreach ($role->permissions as $permission) {
                $this->assertTrue($user->hasPermissionThroughRole($permission));
            }

            if (isset($permission)) {

                switch ($permission->slug) {
                    case 'manage-users':
                        $this->assert_if_route_can_be_accessed();
                        break;

                    case 'manage-roles':
                    case 'manage-permissions':
                        $this->assert_if_route_can_be_accessed('/admin/role-permission/manage');
                        break;

                    default:
                        break;
                }
            }

        });
    }

}

