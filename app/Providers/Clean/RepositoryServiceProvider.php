<?php

namespace App\Providers\Clean;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Interfaces\Repositories\UserRepositoryInterface;
use Modules\Clean\Interfaces\Repositories\CategoryRepositoryInterface;
use Modules\Clean\Interfaces\Repositories\DocumentRepositoryInterface;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Clean\Interfaces\Repositories\PostRepositoryInterface;
use Modules\Clean\Interfaces\Repositories\TagRepositoryInterface;
use Modules\Clean\Interfaces\Services\ArchiveEntityServiceInterface;
use Modules\Clean\Interfaces\Services\DateTimeServiceInterface;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Interfaces\Services\RolePermissionServiceInterface;
use Modules\Clean\Repositories\CategoryRepository;
use Modules\Clean\Repositories\DocumentRepository;
use Modules\Clean\Repositories\ModelRepository;
use Modules\Clean\Repositories\PostRepository;
use Modules\Clean\Repositories\TagRepository;
use Modules\Clean\Repositories\UserRepository;
use Modules\Clean\Services\ArchiveEntityService;
use Modules\Clean\Services\DateTimeService;
use Modules\Clean\Services\ImageService;
use Modules\Clean\Services\RolePermissionService;
use Modules\Event\Interfaces\Repositories\EventRepositoryInterface;
use Modules\Event\Repositories\EventRepository;
use Modules\Job\Interfaces\ClientRepositoryInterface;
use Modules\Job\Interfaces\JobRepositoryInterface;
use Modules\Job\Interfaces\WorkerRepositoryInterface;
use Modules\Job\Repositories\ClientRepository;
use Modules\Job\Repositories\JobRepository;
use Modules\Job\Repositories\WorkerRepository;
use Modules\Social\Interfaces\Services\SocialServiceInterface;
use Modules\Social\Servives\SocialService;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);

        /* Custom */
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(WorkerRepositoryInterface::class, WorkerRepository::class);


        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
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
