<?php

namespace Modules\Auth\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Traits\InteractsWithBanner;

class UserController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(): Factory|View|Application
    {
        $this->authorize('viewAny', User::class);

        $users = User::getPaginatedUsersWithRoles();
        $roles = Role::all();

        return view('admin.pages.auth.user.manage')->with([
            'users' => $users,
            'roles' => $roles,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'role' => ['required', 'numeric', 'min:1', 'max:2'],
        ]);

        User::create([
            'name' => htmlspecialchars($request->name),
            'email' => htmlspecialchars($request->email),
            'password' => Hash::make($request->password),
            'role' => intval($request->role), // 1 = admin, 2 = client
            'remember_token' => Str::random(10),
        ]);

        $this->banner(__('Successfully created the user with the name of ":name"!',
            [htmlspecialchars($request->name)]));

        return redirect()->route('user.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', [User::class, $user]);

        $oldName = htmlentities($user->name);
        $user->deleteOrFail();

        $this->banner(__('Successfully deleted the user with the name of ":name"!', [$oldName]));

        return redirect()->route('user.manage');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @param  User  $user
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function deleteAccount(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', [User::class, $user]);
        $oldName = htmlentities($user->name);

        if (Hash::check($request->input('password'), $user->password)) {
            $user->deleteOrFail();

            $this->banner(__('Successfully deleted the user with the name of ":name"!', [$oldName]));

            return redirect()->route('login');

        } else {
            $this->banner(__('Incorrect password. Try again.'), 'danger');

            return redirect()->route('user.account', $user->id);
        }
    }


    /**
     * Show user account with current user data
     *
     * @param  User  $user
     *
     * @return Factory|View|Application
     * @throws AuthorizationException
     */
    public function account(User $user): Factory|View|Application
    {
        $this->authorize('view', [User::class, $user]);

        $timezoneIdentifiers = ['UTC', ...\DateTimeZone::listIdentifiers(\DateTimeZone::EUROPE)];

        $userPreferences = $user->preferences ?? null;

        return view('admin.pages.auth.user.account')->with([
            'user' => $user,
            'languagesArray' => config('app.available_locales'),
            'defaultLocale' => config('app.locale'),
            'defaultTimezone' => config('app.timezone'),
            'timezoneIdentifiers' => $timezoneIdentifiers,
            'userPreferences' => $userPreferences,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Throwable
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', [User::class, $user]);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:0'],
            'enable2fa' => ['nullable', 'boolean'],
        ];

        if ($user->hasPreferences()) {
            $rules = [
                ...$rules,
                'preferences.darkmode' => ['nullable', 'boolean'],
                'preferences.locale' => ['required', 'string', 'min:2'],
                'preferences.timezone' => ['required', 'string'],
            ];
        }

        $request->validate($rules);

        if ($request->password === null) {
            $user->updateOrFail([
                'name' => strip_tags($request->name),
                'enable_2fa' => intval($request->enable2fa),
            ]);
        } else {
            $user->updateOrFail([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'enable_2fa' => intval($request->enable2fa),
            ]);
        }

        // Save your preferences
        if ($user->hasPreferences()) {

            $preferences = $request->input('preferences');

            // disable darkmode
            if ( ! array_key_exists('darkmode', $preferences)) {
                $preferences['darkmode'] = false;
            }

            $user->updatePreferences($preferences);
        }

        $this->banner(__('Successfully updated your account!'));
        return redirect()->route('user.account', $user->id);
    }
}
