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
        'slug' => ['required', 'alpha_dash', 'max:255', 'unique:roles'],
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
     * @param  Collection  $permissions
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(Collection $permissions, bool $hasSmallButton = false): void
    {
        $this->modalId = 'm-new-role';
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->name = '';
        $this->slug = '';

        $this->rolePermissions = [];
        $this->allPermissions = $permissions;
    }


    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('admin.livewire.auth.role.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createRole(): Redirector
    {
        $this->authorize('create', Role::class);

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                $newRole = $this->rolePermissionService->createRole([
                    'name' => htmlspecialchars($this->name),
                    'slug' => htmlspecialchars($this->slug),
                ]);

                $this->rolePermissionService->syncPermissionsToRole($newRole, $this->rolePermissions);
            }
        );

        $this->banner(__('Successfully created the role ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('role-permission.manage');
    }


}
