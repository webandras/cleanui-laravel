<?php

use App\Http\Controllers\Admin\Clean\CategoryController;
use App\Http\Controllers\Admin\Clean\DashboardController;
use App\Http\Controllers\Admin\Clean\DocumentController;
use App\Http\Controllers\Admin\Clean\FileManagerController;
use App\Http\Controllers\Admin\Clean\PostController;
use App\Http\Controllers\Admin\Clean\RolePermissionController;
use App\Http\Controllers\Admin\Clean\TagController;
use App\Http\Controllers\Admin\Clean\UserController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Event\LocationController;
use App\Http\Controllers\Admin\Event\OrganizerController;
use App\Http\Controllers\Admin\Job\JobClientController;
use App\Http\Controllers\Admin\Job\JobCalendarController;
use App\Http\Controllers\Admin\Job\JobStatsController;
use App\Http\Controllers\Admin\Job\JobWorkerController;
use App\Http\Controllers\Auth\Clean\UserCodeController;
use App\Http\Controllers\Demo\Clean\DemoController;
use App\Http\Controllers\Public\Clean\BlogController;
use App\Http\Controllers\Public\Event\EventController as PublicEventController;
use App\Http\Controllers\Public\Clean\DocumentationController;
use App\Http\Controllers\Social\Clean\FacebookController;
use App\Http\Controllers\Social\Clean\GoogleController;
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

        /* Frontpage */
        Route::get('/', function () {
            return view('welcome');
        })->name('frontpage');
        /* Frontpage END */


        /* 2FA */
        Route::get('2fa', [UserCodeController::class, 'index'])->name('2fa.index');
        /* 2FA END */


        /* Social Login endpoints */
        // Facebook
        Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
        Route::get('auth/callback/facebook', [FacebookController::class, 'handleCallback'])->name('facebook.callback');

        // Google
        Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('auth/callback/google', [GoogleController::class, 'handleCallback'])->name('google.callback');
        /* Social Login endpoints END */


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


        /* Events */
        Route::get('event-calendar', [PublicEventController::class, 'index'])->name('event.index');
        Route::get('event/{slug}', [PublicEventController::class, 'show'])->name('event.show');
        /* Events END */

    }
);


/* Auth endpoints */
Route::group(
    ['prefix' => 'admin'],
    function () {

        /* Login/Logout/Register */
        Route::get('login', 'App\Http\Controllers\Auth\Clean\LoginController@showLoginForm')->name('login');
        Route::post('login', 'App\Http\Controllers\Auth\Clean\LoginController@login');
        Route::post('logout', 'App\Http\Controllers\Auth\Clean\LoginController@logout')->name('logout');
        Route::get('register', 'App\Http\Controllers\Auth\Clean\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'App\Http\Controllers\Auth\Clean\RegisterController@register');
        /* Login/Logout/Register END */


        /* Password */
        Route::get('password/reset',
            'App\Http\Controllers\Auth\Clean\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email',
            'App\Http\Controllers\Auth\Clean\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}',
            'App\Http\Controllers\Auth\Clean\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset',
            'App\Http\Controllers\Auth\Clean\ResetPasswordController@reset')->name('password.update');
        Route::get('password/confirm',
            'App\Http\Controllers\Auth\Clean\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'App\Http\Controllers\Auth\Clean\ConfirmPasswordController@confirm');
        /* Password END */


        /* Email */
        Route::get('email/verify',
            'App\Http\Controllers\Auth\Clean\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}',
            'App\Http\Controllers\Auth\Clean\VerificationController@verify')->name('verification.verify');
        Route::post('email/resend',
            'App\Http\Controllers\Auth\Clean\VerificationController@resend')->name('verification.resend');
        /* Email END */

    });


// Routes only for authenticated users
Route::group(
    ['middleware' => ['auth', 'verified', '2fa', 'role:super-administrator|administrator'], 'prefix' => 'admin'],
    function () {

        Route::get('user/manage', [UserController::class, 'index'])->name('user.manage');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


        /* Roles and Permissions */
        Route::get('role-permission/manage',
            [RolePermissionController::class, 'index'])->name('role-permission.manage');
        /* Roles and Permissions END */


        /* Tags */
        Route::get('tags/manage', [TagController::class, 'index'])->name('tag.manage');
        /* Tags END */


        /* Categories */
        Route::get('categories/manage', [CategoryController::class, 'index'])->name('category.manage');
        /* Categories END */


        /* Demo page */
        Route::get('/demo', [DemoController::class, 'index'])->name('demo');
        /* Demo page END */


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


        /* Jobs calendar */
        Route::get('worker/manage', [JobWorkerController::class, 'index'])->name('worker.manage');
        Route::get('client/manage', [JobClientController::class, 'index'])->name('client.manage');
        Route::get('jobs/calendar', [JobCalendarController::class, 'index'])->name('job.calendar');
        Route::get('jobs/statistics', [JobStatsController::class, 'index'])->name('job.statistics');
        /* Jobs calendar END */


        /* Events */
        Route::post('event', [EventController::class, 'store'])->name('event.store');
        Route::get('event/create', [EventController::class, 'create'])->name('event.create');
        Route::get('event/manage', [EventController::class, 'index'])->name('event.manage');
        Route::get('event/{event:id}', [EventController::class, 'edit'])->name('event.edit');
        Route::put('event/{event}', [EventController::class, 'update'])->name('event.update');
        Route::delete('event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
        /* Events END */


        /* Locations */
        Route::get('locations/manage', [LocationController::class, 'index'])->name('location.manage');
        /* Locations END */


        /* Organizers */
        Route::get('organizers/manage', [OrganizerController::class, 'index'])->name('organizer.manage');
        /* Organizers END */

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
        Route::get('2fa/reset', [UserCodeController::class, 'resend'])->name('2fa.resend');
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

