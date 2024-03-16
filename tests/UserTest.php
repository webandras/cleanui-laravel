<?php

namespace Tests;

use App\Models\Clean\Role;
use App\Models\Clean\User;
use Illuminate\Support\Facades\DB;


class UserTest extends TestCase
{

    protected function assert_if_route_can_be_accessed(string $path = '/admin/user/manage')
    {
        $response = $this->get($path);
        $response->assertHeader('content-type', 'text/html; charset=UTF-8');
        $response->assertStatus(200);
    }



    protected function assert_if_user_has_permission_to_routes(User $user, Role $role) {
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

