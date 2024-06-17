<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserCodeController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Clean\Admin\CategoryController;
use App\Http\Controllers\Clean\Admin\DashboardController;
use App\Http\Controllers\Clean\Admin\DocumentController;
use App\Http\Controllers\Clean\Admin\FileManagerController;
use App\Http\Controllers\Clean\Admin\PostController;
use App\Http\Controllers\Clean\Admin\RolePermissionController;
use App\Http\Controllers\Clean\Admin\TagController;
use App\Http\Controllers\Clean\Admin\UserController;
use App\Http\Controllers\Clean\LocalizationController;
use App\Http\Controllers\Clean\Public\BlogController;
use App\Http\Controllers\Clean\Public\DocumentationController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\Event\Admin\EventController;
use App\Http\Controllers\Event\Admin\LocationController;
use App\Http\Controllers\Event\Admin\OrganizerController;
use App\Http\Controllers\Event\Public\EventController as PublicEventController;
use App\Http\Controllers\Job\Admin\JobCalendarController;
use App\Http\Controllers\Job\Admin\JobClientController;
use App\Http\Controllers\Job\Admin\JobStatsController;
use App\Http\Controllers\Job\Admin\JobWorkerController;
use App\Http\Controllers\Social\FacebookController;
use App\Http\Controllers\Social\GoogleController;
use Illuminate\Support\Facades\Artisan;
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


        /* Get language, set language in session */
        Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang.index');
        /* Get language, set language in session END */

    }
);


/* Auth endpoints */
Route::group(
    ['prefix' => 'admin'],
    function () {

        /* Login/Logout/Register */
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
        /* Login/Logout/Register END */


        /* Password */
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
        Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
        Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
        /* Password END */


        /* Email */
        Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
        Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
        /* Email END */

    });


// Routes only for authenticated users
Route::group(
    ['middleware' => ['auth', 'verified', '2fa', 'role:super-administrator|administrator'], 'prefix' => 'admin'],
    function () {

        /* Manage Users */
        Route::get('user/manage', [UserController::class, 'index'])->name('user.manage');
        /* Manage Users END */


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

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /* Demo page */
        Route::get('/demo', [DemoController::class, 'index'])->name('demo');
        /* Demo page END */

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
});*/

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
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    echo 'Cache clear OK';
    exit;
});

