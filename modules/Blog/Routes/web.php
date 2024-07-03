<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Controllers\Admin\CategoryController;
use Modules\Blog\Controllers\Admin\DashboardController;
use Modules\Blog\Controllers\Admin\DemoController;
use Modules\Blog\Controllers\Admin\DocumentController;
use Modules\Blog\Controllers\Admin\FileManagerController;
use Modules\Blog\Controllers\Admin\PostController;
use Modules\Blog\Controllers\Admin\TagController;
use Modules\Blog\Controllers\Public\BlogController;
use Modules\Blog\Controllers\Public\DocumentationController;

/* Public routes */
Route::group(
    ['middleware' => ['web']],
    function () {
        /* Frontpage */
        Route::get('/', function () {
            return view('welcome');
        })->name('frontpage');
        /* Frontpage END */

        /* Blog */
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('blog/info/{slug}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('blog/category/{category}', [BlogController::class, 'category'])->name('blog.category');
        Route::get('blog/tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');
        /* Blog END */

        /* Documentation */
        Route::get('/documentation', [DocumentationController::class, 'index'])->name('document.index');
        Route::get('/documentation/{slug}', [DocumentationController::class, 'show'])->name('document.show');
        /* Documentation END */
    }
);
/* Public routes END */


/* Dashboard and demo for authenticated users */
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified', '2fa']
    ],
    function () {
        /* Dashboard page */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        /* Dashboard page END */

        /* Demo page */
        Route::get('/demo', [DemoController::class, 'index'])->name('demo');
        /* Demo page END */
    }
);
/* Dashboard and demo for authenticated users END */


/* Routes only for authenticated users */
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified', '2fa', 'role:super-administrator|administrator']
    ],
    function () {
        /* Tags */
        Route::get('tags/manage', [TagController::class, 'index'])->name('tag.manage');
        /* Tags END */

        /* Categories */
        Route::get('categories/manage', [CategoryController::class, 'index'])->name('category.manage');
        /* Categories END */

        /* Docs */
        Route::post('document', [DocumentController::class, 'store'])->name('document.store');
        Route::get('document/create', [DocumentController::class, 'create'])->name('document.create');
        Route::get('documents/manage', [DocumentController::class, 'index'])->name('document.manage');
        Route::get('document/{document}', [DocumentController::class, 'edit'])->name('document.edit');
        Route::put('document/{document}', [DocumentController::class, 'update'])->name('document.update');
        Route::delete('document/{document}', [DocumentController::class, 'destroy'])->name('document.destroy');
        /* Docs END */

        /* Posts */
        Route::post('post', [PostController::class, 'store'])->name('post.store');
        Route::get('post/create', [PostController::class, 'create'])->name('post.create');
        Route::get('posts/manage', [PostController::class, 'index'])->name('post.manage');
        Route::get('post/{post}', [PostController::class, 'edit'])->name('post.edit');
        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        /* Posts END */

        /* File Manager */
        Route::get('file-manager', [FileManagerController::class, 'index'])->name('filemanager');
        /* File Manager END */
    }
);
