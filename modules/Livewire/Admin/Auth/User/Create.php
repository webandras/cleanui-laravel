<?php

namespace Modules\Livewire\Admin\Auth\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\RolePermissionServiceInterface;
use Modules\Auth\Models\User;
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
    public string $email;


    /**
     * @var string
     */
    public string $password;


    /**
     * @var int|null
     */
    public ?int $role;


    /**
     * @var array
     */
    public array $rolesArray;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string'],
        'role' => ['required', 'integer'],
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
        $this->modalId = 'm-new-user';
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = null;

        $allRoles = $roles;
        foreach ($allRoles as $role) {
            $this->rolesArray[$role->id] = $role->name;
        }

    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.auth.user.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createUser(): Redirector
    {
        $this->authorize('create', User::class);

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                $newUser = User::create([
                    'name' => htmlspecialchars($this->name),
                    'email' => htmlspecialchars($this->email),
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(10),
                    'role_id' => $this->role ?? 2,
                ]);


                // Save the user-role relation
                $role = $this->rolePermissionService->getRoleById($this->role);

                $this->rolePermissionService->associateRoleWithUser($role, $newUser);
            }
        );

        $this->banner(__('Successfully created the user ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('user.manage');
    }

}
