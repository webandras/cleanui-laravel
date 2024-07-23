<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Document;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Tag;
use Modules\Blog\Policies\CategoryPolicy;
use Modules\Blog\Policies\DocumentPolicy;
use Modules\Blog\Policies\PostPolicy;
use Modules\Blog\Policies\TagPolicy;

class BlogModuleProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/../views', 'blog');

        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
    }
}
