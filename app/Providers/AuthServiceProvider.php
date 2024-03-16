<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Clean\Category' => 'App\Policies\Clean\CategoryPolicy',
        'App\Models\Clean\Document' => 'App\Policies\Clean\DocumentPolicy',
        'App\Models\Clean\Permission' => 'App\Policies\Clean\PermissionPolicy',
        'App\Models\Clean\Post' => 'App\Policies\Clean\PostPolicy',
        'App\Models\Clean\Role' => 'App\Policies\Clean\RolePolicy',
        'App\Models\Clean\Tag' => 'App\Policies\Clean\TagPolicy',
        'App\Models\Clean\User' => 'App\Policies\Clean\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
