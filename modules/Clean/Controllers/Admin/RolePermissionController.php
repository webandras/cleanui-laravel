<?php

namespace Modules\Clean\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Interfaces\Services\RolePermissionServiceInterface;
use Modules\Clean\Models\Role;

class RolePermissionController extends Controller
{
    use InteractsWithBanner, UserPermissions;


    /**
     * @var RolePermissionServiceInterface
     */
    private RolePermissionServiceInterface $rolePermissionService;


    /**
     * @param  RolePermissionServiceInterface  $rolePermissionService
     */
    public function __construct(RolePermissionServiceInterface $rolePermissionService)
    {
        $this->rolePermissionService = $rolePermissionService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(): View|Factory|Application
    {
        $this->authorize('viewAny', Role::class);

        $permissions = $this->rolePermissionService->getPermissionsWithRoles();
        $roles = $this->rolePermissionService->getRolesWithPermissions();

        return view('admin.pages.role_permission.manage')->with([
            'permissions' => $permissions,
            'roles' => $roles,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }
}
