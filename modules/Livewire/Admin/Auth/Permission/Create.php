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

class Create extends Component
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
        'slug' => ['required', 'alpha_dash', 'max:255', 'unique:permissions'],
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
     * @param  Collection  $roles
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(Collection $roles, bool $hasSmallButton = false): void
    {
        $this->modalId = 'm-new-permission';
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->name = '';
        $this->slug = '';

        $this->allRoles = $roles;
        $this->permissionRoles = [];
    }


    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('admin.livewire.auth.permission.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createPermission(): Redirector
    {
        $this->authorize('create', Permission::class);

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                $newPermission = $this->rolePermissionService->createPermission([
                    'name' => htmlspecialchars($this->name),
                    'slug' => htmlspecialchars($this->slug),
                ]);

                $this->rolePermissionService->syncRolesToPermission($newPermission, $this->permissionRoles);
            }
        );

        $this->banner(__('Successfully created the permission ":name"!', ['name' => htmlspecialchars($this->name)]));
        request()->session()->flash('flash.activeTab', 'Permissions');

        return redirect()->route('role-permission.manage');
    }


}
