<?php

namespace Modules\Livewire\Admin\Auth\Role;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\RolePermissionServiceInterface;
use Modules\Auth\Models\Role;
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
     * @var Role
     */
    public Role $role;


    /**
     * @var int
     */
    public int $roleId;


    /**
     * @var Collection
     */
    public Collection $allPermissions;


    /**
     * @var array
     */
    public array $rolePermissions;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'rolePermissions' => ['array']
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
     * @param  Collection  $permissions
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Role $role, Collection $permissions, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->role = $role;
        $this->roleId = $this->role->id;
        $this->name = $this->role->name;
        $this->slug = $this->role->slug;

        $this->rolePermissions = $this->rolePermissionService->getRelatedIds($this->role->permissions);
        $this->allPermissions = $permissions;
    }


    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('admin.livewire.auth.role.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateRole(): Redirector
    {
        $this->authorize('update', [Role::class, $this->role]);

        $role = $this->rolePermissionService->getRoleById($this->roleId);
        $this->authorize('update', [Role::class, $role]);

        // if slug is changed, enable this validation
        if ($this->slug !== $this->role->slug) {
            $this->rules['slug'] = ['required', 'string', 'max:255', 'unique:roles'];
        }

        // validate user input
        $this->validate();

        DB::transaction(
            function () use ($role) {

                if ($this->slug === $this->role->slug) {

                    $this->rolePermissionService->updateRole($role, [
                        'name' => htmlspecialchars($this->name),
                        'slug' => htmlspecialchars($this->slug),
                    ]);
                } else {
                    $this->rolePermissionService->updateRole($role, [
                        'name' => htmlspecialchars($this->name),
                    ]);
                }

                $this->rolePermissionService->syncPermissionsToRole($role, $this->rolePermissions);
            }
        );

        $this->banner(__('Successfully updated the role ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('role-permission.manage');
    }

}
