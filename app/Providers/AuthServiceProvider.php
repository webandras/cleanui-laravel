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
        'Modules\Clean\Models\Category' => 'Modules\Clean\Policies\CategoryPolicy',
        'Modules\Clean\Models\Document' => 'Modules\Clean\Policies\DocumentPolicy',
        'Modules\Clean\Models\Permission' => 'Modules\Clean\Policies\PermissionPolicy',
        'Modules\Clean\Models\Post' => 'Modules\Clean\Policies\PostPolicy',
        'Modules\Clean\Models\Role' => 'Modules\Clean\Policies\RolePolicy',
        'Modules\Clean\Models\Tag' => 'Modules\Clean\Policies\TagPolicy',
        'Modules\Auth\Models\User' => 'Modules\Clean\Policies\UserPolicy',

        /* Jobs module */
        'Modules\Job\Models\Job' => 'Modules\Job\Policies\JobPolicy',
        'Modules\Job\Models\Client' => 'Modules\Job\Policies\ClientPolicy',
        'Modules\Job\Models\Worker' => 'Modules\Job\Policies\WorkerPolicy',
        /* Jobs module END */

        /* Events module */
        'Modules\Event\Model\Event' => 'Modules\Event\Event\EventPolicy',
        'Modules\Event\Model\Location' => 'Modules\Event\Event\LocationPolicy',
        'Modules\Event\Model\Organizer' => 'Modules\Event\Event\OrganizerPolicy',
        /* Events module END */

    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
