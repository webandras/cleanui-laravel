<?php

namespace Modules\Livewire\Admin\Auth\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Auth\Models\User;
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
    public int $userId;


    /**
     * @var User
     */
    public User $user;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'userId' => 'required|int|min:1',
    ];


    /**
     * @param  string  $modalId
     * @param  User  $user
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, User $user, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->user = $user;
        $this->userId = $user->id;
        $this->name = $user->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.auth.user.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteUser(): Redirector
    {
        $this->authorize('delete', [User::class, $this->user]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->user->deleteOrFail();
            }
        );

        $this->banner(__('The user with the name ":name" was successfully deleted.',
            ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('user.manage');
    }
}
