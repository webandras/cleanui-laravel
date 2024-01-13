<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\UserCodeController;
use App\Http\Controllers\Social\FacebookController;
use App\Http\Controllers\Social\GoogleController;
use Illuminate\Support\Facades\Route;

// use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Auth endpoints from Laravel UI */
/*Auth::routes([
    'verify' => true,
    'register' => false,
]);*/
/* Auth endpoints from Laravel UI END */


// Public routes
Route::group(
    [],
    function () {
        /* Clean.ui Demo page */
        Route::get('/', function () {
            return view('welcome');
        })->name('frontpage');


        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        /* 2FA */
        Route::get('2fa', [UserCodeController::class, 'index'])->name('2fa.index');
        /* 2FA END */


        /* Social Login endpoints */
        Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
        Route::get('auth/callback/facebook', [FacebookController::class, 'handleCallback'])->name('facebook.callback');

        Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('auth/callback/google', [GoogleController::class, 'handleCallback'])->name('google.callback');
        /* Social Login endpoints END */
    }
);


/* Auth endpoints */
Route::group(
    ['prefix' => 'admin'],
    function () {

        /* Login/Logout/Register */
        Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
        Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
        Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');
        /* Login/Logout/Register END */


        /* Password */
        Route::get('password/reset',
            'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email',
            'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}',
            'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset',
            'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
        Route::get('password/confirm',
            'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');
        /* Password END */


        /* Email */
        Route::get('email/verify',
            'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}',
            'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
        Route::post('email/resend',
            'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
        /* Email END */

    });


// Routes only for authenticated users
Route::group(
    ['middleware' => ['auth', 'verified', '2fa', 'role:super-administrator|administrator'], 'prefix' => 'admin'],
    function () {

        Route::get('user/manage', [UserController::class, 'index'])->name('user.manage');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        /* Roles and Permissions */
        Route::get('role-permission/manage', [RolePermissionController::class, 'index'])
            ->name('role-permission.manage');
        /* Roles and Permissions END */


        /* Tags */
        Route::get('tags/manage', [TagController::class, 'index'])->name('tag.manage');
        /* Tags END */


        /* Categories */
        Route::get('categories/manage', [CategoryController::class, 'index'])->name('category.manage');
        /* Categories END */


        /* Posts */
        Route::post('post', [PostController::class, 'store'])->name('post.store');
        Route::get('post/create', [PostController::class, 'create'])->name('post.create');
        Route::get('posts/manage', [PostController::class, 'index'])->name('post.manage');

        Route::get(
            'post/{post}', [PostController::class, 'edit'])->name('post.edit');

        Route::put('post/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        /* Posts END */


        Route::get(
            'file-manager', [FileManagerController::class, 'index'])->name('filemanager');
    }
);


// for super admins, simple admins, and editors
Route::group(
    ['middleware' => ['auth', 'verified', '2fa'], 'prefix' => 'admin'],
    function () {

        /* Account/Users */
        Route::get('user/account/{user}', [UserController::class, 'account'])->name('user.account');
        Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::delete('user/account/delete/{user}',
            [UserController::class, 'deleteAccount'])->name('user.account.delete');
        /* Account/Users END */

    }
);


Route::group(
    ['middleware' => ['auth', 'verified']],
    function () {

        /* 2fa endpoints for authenticated users */
        Route::post('2fa', [UserCodeController::class, 'store'])->name('2fa.post');
        Route::get('2fa/reset', [UserCodeController::class, 'resend'])
            ->name('2fa.resend');
        /* 2fa endpoints for authenticated users END */

    });
// Routes only for authenticated users END


// Other routes (for testing / artisan commands)
/*Route::get('/art', function () {
//    Artisan::call('storage:link');
    Artisan::call('migrate',
        array(
            '--path' => 'database/migrations',
            '--database' => 'mysql',
            '--force' => true
        ));
    // Do whatever you want either a print a message or exit
    echo 'OK';
    exit;
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    echo 'OK';
    exit;
});


Route::get('/cache', function () {
    Artisan::call('route:cache');
    echo 'Optimize OK';
    exit;
});


Route::get('/clear', function () {
    Artisan::call('route:clear');
    echo 'Route cache clear OK';
    exit;
});*/

