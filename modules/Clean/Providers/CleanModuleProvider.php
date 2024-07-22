<?php

namespace Modules\Clean\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\Services\RolePermissionServiceInterface;
use Modules\Auth\Interfaces\Services\SocialServiceInterface;
use Modules\Auth\Services\RolePermissionService;
use Modules\Auth\Services\SocialService;
use Modules\Blog\Interfaces\Repositories\CategoryRepositoryInterface;
use Modules\Blog\Interfaces\Repositories\DocumentRepositoryInterface;
use Modules\Blog\Interfaces\Repositories\PostRepositoryInterface;
use Modules\Blog\Interfaces\Repositories\TagRepositoryInterface;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Repositories\DocumentRepository;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Repositories\TagRepository;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Clean\Interfaces\Services\ArchiveEntityServiceInterface;
use Modules\Clean\Interfaces\Services\DateTimeServiceInterface;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Repositories\ModelRepository;
use Modules\Clean\Services\ArchiveEntityService;
use Modules\Clean\Services\DateTimeService;
use Modules\Clean\Services\ImageService;

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
        $this->app->bind(SocialServiceInterface::class, SocialService::class);

        /* repositories */
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ModelRepositoryInterface::class, ModelRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);

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
