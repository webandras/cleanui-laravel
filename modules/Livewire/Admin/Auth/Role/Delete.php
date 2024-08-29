<?php

namespace Modules\Livewire\Admin\Auth\Role;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\RolePermissionServiceInterface;
use Modules\Auth\Models\Role;
use Modules\Clean\Traits\InteractsWithBanner;

class Delete extends Component
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
     * @var int
     */
    public int $roleId;


    /**
     * @var Role
     */
    public Role $role;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'roleId' => 'required|int|min:1',
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
     * @param  Role  $role
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Role $role, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->role = $role;
        $this->roleId = $role->id;
        $this->name = $role->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.auth.role.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteRole(): Redirector
    {
        $this->authorize('delete', [Role::class, $this->role]);

        // validate user input
        $this->validate();

        // delete role, rollback transaction if fails
        DB::transaction(
            function () {
                $this->rolePermissionService->deleteRole($this->role);
            }
        );

        $this->banner(__('The role with the name ":name" was successfully deleted.',
            ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('role-permission.manage');
    }
}
