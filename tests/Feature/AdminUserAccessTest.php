<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;
use Tests\UserTest;


class AdminUserAccessTest extends UserTest
{
    use DatabaseTransactions;

    private User $user;


    public function setUp(): void
    {
        parent::setUp();

        // create user
        $this->user = User::findOrFail(4);
    }


    /**
     * Admin user exists
     */
    public function test_admin_user_exists(): void
    {
        $hasUser = (bool) $this->user;
        $this->assertTrue($hasUser);
    }


    /**
     * Admin user can access these admin routes if logged-in
     */
    public function test_admin_user_no2fa_can_access_dashboard(): void
    {
        $this->actingAs($this->user, 'web');
        $this->assertAuthenticated();
        Session::put('user_2fa', $this->user->id);

        $role = Role::with('permissions')->find(2);

        // Test if user has all permissions from role, can access admin routes
        $this->assert_if_user_has_permission_to_routes($this->user, $role);

        $this->assertEquals(2, $this->user->role_id);
        // Can admin user access the admin dashboard
        $this->assert_if_route_can_be_accessed('/admin/dashboard');
    }
}
