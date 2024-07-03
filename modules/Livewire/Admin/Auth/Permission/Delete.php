<?php

namespace Modules\Livewire\Admin\Auth\Permission;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\Services\RolePermissionServiceInterface;
use Modules\Auth\Models\Permission;
use Modules\Clean\Traits\InteractsWithBanner;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
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


    // inputs
    /**
     * @var int
     */
    public int $permissionId;


    /**
     * @var Permission
     */
    public Permission $permission;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'permissionId' => 'required|int|min:1',
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
     * @param  Permission  $permission
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Permission $permission, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->permission = $permission;
        $this->permissionId = $permission->id;
        $this->name = $permission->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.auth.permission.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deletePermission(): Redirector
    {
        $this->authorize('delete', [Permission::class, $this->permission]);

        // validate user input
        $this->validate();

        // delete role, rollback transaction if fails
        DB::transaction(
            function () {
                $this->rolePermissionService->deletePermission($this->permission);
            },
            2
        );

        $this->banner(__('The permission with the name ":name" was successfully deleted.',
            ['name' => htmlspecialchars($this->name)]));
        request()->session()->flash('flash.activeTab', 'Permissions');

        return redirect()->route('role-permission.manage');
    }
}
