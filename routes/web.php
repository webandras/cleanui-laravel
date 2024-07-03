<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

/* Other routes for testing and calling artisan commands */
Route::get('/art', function () {
    // Artisan::call('storage:link');
    /*Artisan::call('migrate',
        array(
            '--path' => 'database/migrations',
            '--database' => 'mysql',
            '--force' => true
        ));*/
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
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    echo 'Cache clear OK';
    exit;
});
