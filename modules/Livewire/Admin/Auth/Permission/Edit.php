<?php

namespace Modules\Livewire\Admin\Auth\Permission;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\Services\RolePermissionServiceInterface;
use Modules\Auth\Models\Permission;
use Modules\Clean\Traits\InteractsWithBanner;

class Edit extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    /**
     * @var string
     */
    public string $modalId;


    /**
     * @var bool
     */
    public bool $isModalOpen;


    /**
     * @var bool
     */
    public bool $hasSmallButton;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var string
     */
    public string $slug;


    /**
     * @var Permission
     */
    public Permission $permission;


    /**
     * @var int
     */
    public int $permissionId;


    /**
     * @var Collection
     */
    public Collection $allRoles;


    /**
     * @var array
     */
    public array $permissionRoles;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'permissionRoles' => ['array'],
    ];


    /**
     * @var RolePermissionServiceInterface
     */
    private RolePermissionServiceInterface $rolePermissionService;


    /**
     * @param  RolePermissionServiceInterface  $rolePermissionService
     * @return void
     */
    public function boot(RolePermissionServiceInterface $rolePermissionService): void
    {
        $this->rolePermissionService = $rolePermissionService;
    }


    /**
     * @param  string  $modalId
     * @param  Collection  $roles
     * @param  Permission  $permission
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(
        string $modalId,
        Collection $roles,
        Permission $permission,
        bool $hasSmallButton = false
    ): void {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->permission = $permission;
        $this->permissionId = $this->permission->id;
        $this->name = $this->permission->name;
        $this->slug = $this->permission->slug;

        $this->allRoles = $roles;
        $this->permissionRoles = $this->rolePermissionService->getRelatedIds($this->permission->roles);
    }


    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('admin.livewire.auth.permission.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updatePermission(): Redirector
    {
        $this->authorize('update', [Permission::class, $this->permission]);

        // if slug is changed, enable this validation
        if ($this->slug !== $this->permission->slug) {
            $this->rules['slug'] = ['required', 'string', 'max:255', 'unique:permissions'];
        }

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                if ($this->slug !== $this->permission->slug) {

                    $this->rolePermissionService->updatePermission($this->permission, [
                        'name' => htmlspecialchars($this->name),
                        'slug' => htmlspecialchars($this->slug),
                    ]);
                } else {
                    $this->rolePermissionService->updatePermission($this->permission, [
                        'name' => htmlspecialchars($this->name),
                    ]);
                }

                $this->rolePermissionService->syncRolesToPermission($this->permission, $this->permissionRoles);
            }
        );

        $this->banner(__('Successfully updated the permission ":name"!', ['name' => htmlspecialchars($this->name)]));
        request()->session()->flash('flash.activeTab', 'Permissions');

        return redirect()->route('role-permission.manage');
    }

}
