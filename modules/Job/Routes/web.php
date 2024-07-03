<?php

use Illuminate\Support\Facades\Route;
use Modules\Job\Controllers\Admin\JobCalendarController;
use Modules\Job\Controllers\Admin\JobClientController;
use Modules\Job\Controllers\Admin\JobStatsController;
use Modules\Job\Controllers\Admin\JobWorkerController;

// Routes only for authenticated users
Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['web', 'auth', 'verified', '2fa', 'role:super-administrator|administrator']
    ],
    function () {
        /* Jobs calendar */
        Route::get('worker/manage', [JobWorkerController::class, 'index'])->name('worker.manage');
        Route::get('client/manage', [JobClientController::class, 'index'])->name('client.manage');
        Route::get('jobs/calendar', [JobCalendarController::class, 'index'])->name('job.calendar');
        Route::get('jobs/statistics', [JobStatsController::class, 'index'])->name('job.statistics');
        /* Jobs calendar END */
    }
);
