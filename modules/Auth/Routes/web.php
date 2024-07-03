<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\Admin\RolePermissionController;
use Modules\Auth\Controllers\Admin\UserController;
use Modules\Auth\Controllers\ConfirmPasswordController;
use Modules\Auth\Controllers\ForgotPasswordController;
use Modules\Auth\Controllers\LoginController;
use Modules\Auth\Controllers\RegisterController;
use Modules\Auth\Controllers\ResetPasswordController;
use Modules\Auth\Controllers\Social\FacebookController;
use Modules\Auth\Controllers\Social\GoogleController;
use Modules\Auth\Controllers\UserCodeController;
use Modules\Auth\Controllers\VerificationController;
use Modules\Clean\Controllers\LocalizationController;

/* Public auth endpoints */
Route::group(
    ['middleware' => ['web']],
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

        /* Social Login endpoints */
        Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
        Route::get('auth/callback/facebook', [FacebookController::class, 'handleCallback'])->name('facebook.callback');
        Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('auth/callback/google', [GoogleController::class, 'handleCallback'])->name('google.callback');
        /* Social Login endpoints END */

        /* 2FA */
        Route::get('2fa', [UserCodeController::class, 'index'])->name('2fa.index');
        /* 2FA END */

        /* Get language, set language in session */
        Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang.index');
        /* Get language, set language in session END */
    });
/* Public auth endpoints END */


/* Authenticated endpoints for 2FA code submit and reset */
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified']
    ],
    function () {
        /* 2fa endpoints for authenticated users */
        Route::post('2fa', [UserCodeController::class, 'store'])->name('2fa.post');
        Route::get('2fa/reset', [UserCodeController::class, 'resend'])->name('2fa.resend');
        /* 2fa endpoints for authenticated users END */
    });
/* Authenticated endpoints for 2FA code submit and reset END */


/* Authenticated endpoints for user account management */
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified', '2fa']
    ],
    function () {
        /* Account/Users */
        Route::get('user/account/{user}', [UserController::class, 'account'])->name('user.account');
        Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::delete('user/account/delete/{user}', [UserController::class, 'deleteAccount'])->name('user.account.delete');
        /* Account/Users END */
    }
);
/* Authenticated endpoints for user account management END */


/* Routes only for authenticated users with admin roles */
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified', '2fa', 'role:super-administrator|administrator']
    ],
    function () {
        /* Manage Users */
        Route::get('user/manage', [UserController::class, 'index'])->name('user.manage');
        /* Manage Users END */

        /* Roles and Permissions */
        Route::get('role-permission/manage', [RolePermissionController::class, 'index'])->name('role-permission.manage');
        /* Roles and Permissions END */
    }
);
/* Routes only for authenticated users with admin roles END */
