<?php

namespace Modules\Event\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Event\Models\Event;
use Modules\Event\Models\Location;
use Modules\Event\Models\Organizer;
use Modules\Event\Policies\EventPolicy;
use Modules\Event\Policies\LocationPolicy;
use Modules\Event\Policies\OrganizerPolicy;

class EventModuleProvider extends ServiceProvider
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

        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(Location::class, LocationPolicy::class);
        Gate::policy(Organizer::class, OrganizerPolicy::class);
    }
}
