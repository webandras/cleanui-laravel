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
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Interfaces\Repositories\UserRepositoryInterface;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;
use Modules\Clean\Traits\InteractsWithBanner;

class Edit extends Component
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
     * @var User
     */
    public User $user;


    /**
     * @var int
     */
    public int $userId;


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
        'password' => ['string'],
        'role' => ['required', 'integer'],
    ];


    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;


    /**
     * @param  UserRepositoryInterface  $userRepository
     * @return void
     */
    public function boot(UserRepositoryInterface $userRepository): void
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @param  string  $modalId
     * @param  User  $user
     * @param  Collection  $roles
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(
        string $modalId,
        User $user,
        Collection $roles,
        bool $hasSmallButton = false
    ): void {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->user = $user;
        $this->userId = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = '';

        // initialize roleId property
        if (isset($this->user->role)) {
            $this->role = $this->user->role->id;
        } else {
            $this->role = null;
        }

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
        return view('admin.livewire.auth.user.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateUser(): Redirector
    {
        $this->authorize('update', [User::class, $this->user]);

        // validate user input
        $this->validate();

        DB::transaction(
            function () {

                if (!isset($this->user->role)) {
                    $role = Role::where('slug', 'worker')->first();
                    // attach can only be used on m-m relation
                    // associate <-> dissociate
                    $this->user->role()->associate($role);
                } // Save new role if role is selected, and the value not equal to the current role of the user
                else {
                    if ($this->role && $this->role !== $this->user->role->id) {

                        $this->user->deleteUserRole();

                        $role = Role::where('id', $this->role)->first();
                        $this->user->role()->associate($role);
                    }
                }

                // only save password if a new one is supplied
                if ($this->password !== '') {
                    $this->userRepository->updateUser($this->user, [
                        'name' => htmlspecialchars($this->name),
                        'password' => Hash::make($this->password),
                    ]);
                } else {
                    $this->userRepository->updateUser($this->user, [
                        'name' => htmlspecialchars($this->name),
                    ]);
                }

            },
            2
        );

        $this->banner(__('Successfully updated the user ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('user.manage');
    }

}
