<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Models\Permission;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;
use Modules\Auth\Policies\PermissionPolicy;
use Modules\Auth\Policies\RolePolicy;
use Modules\Auth\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;

class AuthModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'auth');

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }
}
