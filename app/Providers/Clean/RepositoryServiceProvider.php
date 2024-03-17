<?php

namespace App\Providers\Clean;

use App\Interface\Repository\Clean\CategoryRepositoryInterface;
use App\Interface\Repository\Clean\DocumentRepositoryInterface;
use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Interface\Repository\Clean\PostRepositoryInterface;
use App\Interface\Repository\Clean\TagRepositoryInterface;
use App\Interface\Repository\Clean\UserRepositoryInterface;
use App\Interface\Services\Clean\ArchiveEntityServiceInterface;
use App\Interface\Services\Clean\DateTimeServiceInterface;
use App\Interface\Services\Clean\ImageServiceInterface;
use App\Interface\Services\Clean\RolePermissionServiceInterface;
use App\Interface\Services\Clean\SocialServiceInterface;
use App\Repository\Clean\CategoryRepository;
use App\Repository\Clean\DocumentRepository;
use App\Repository\Clean\ModelRepository;
use App\Repository\Clean\PostRepository;
use App\Repository\Clean\TagRepository;
use App\Repository\Clean\UserRepository;
use App\Services\Clean\ArchiveEntityService;
use App\Services\Clean\DateTimeService;
use App\Services\Clean\ImageService;
use App\Services\Clean\RolePermissionService;
use App\Services\Clean\SocialService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(RolePermissionServiceInterface::class, RolePermissionService::class);
        $this->app->bind(ImageServiceInterface::class, ImageService::class);
        $this->app->bind(DateTimeServiceInterface::class, DateTimeService::class);
        $this->app->bind(ModelRepositoryInterface::class, ModelRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(ArchiveEntityServiceInterface::class, ArchiveEntityService::class);
        $this->app->bind(SocialServiceInterface::class, SocialService::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);

        /* Custom ... */

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
        //
    }
}
