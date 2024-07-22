<?php

namespace Modules\Job\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Job\Models\Client;
use Modules\Job\Models\Job;
use Modules\Job\Models\Worker;
use Modules\Job\Policies\ClientPolicy;
use Modules\Job\Policies\JobPolicy;
use Modules\Job\Policies\WorkerPolicy;

class JobModuleProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../Views', 'job');

        Gate::policy(Client::class, ClientPolicy::class);
        Gate::policy(Job::class, JobPolicy::class);
        Gate::policy(Worker::class, WorkerPolicy::class);
    }
}
