<?php

namespace Modules\Clean\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\RolePermissionServiceInterface;
use Modules\Auth\Services\RolePermissionService;
use Modules\Clean\Interfaces\ArchiveEntityServiceInterface;
use Modules\Clean\Interfaces\DateTimeServiceInterface;
use Modules\Clean\Interfaces\ImageServiceInterface;
use Modules\Clean\Interfaces\ModelServiceInterface;
use Modules\Clean\Services\ArchiveEntityService;
use Modules\Clean\Services\DateTimeService;
use Modules\Clean\Services\ImageService;
use Modules\Clean\Services\ModelService;

class CleanModuleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /* services */
        $this->app->bind(RolePermissionServiceInterface::class, RolePermissionService::class);
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(DateTimeServiceInterface::class, DateTimeService::class);
        $this->app->bind(ArchiveEntityServiceInterface::class, ArchiveEntityService::class);

        /* repositories */
        $this->app->bind(ModelServiceInterface::class, ModelService::class);

        /* Custom */
        /* $this->app->when([LocationController::class])
            ->needs(ModelRepositoryInterface::class)
            ->give(LocationRepository::class);
        */
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        View::addNamespace('errors', resource_path('views/errors'));

        Blade::anonymousComponentPath(resource_path('views/global/components'), 'global');
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
        Blade::anonymousComponentPath(resource_path('views/public/components'), 'public');

        // Make some props available for the language switcher
        view()->composer('partials.language_switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });
    }
}
