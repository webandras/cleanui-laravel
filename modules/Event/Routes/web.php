<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Controllers\Admin\EventController;
use Modules\Event\Controllers\Admin\LocationController;
use Modules\Event\Controllers\Admin\OrganizerController;
use Modules\Event\Controllers\Public\EventController as PublicEventController;

/* Public routes */
Route::group(
    ['middleware' => ['web']],
    function () {
        /* Events */
        Route::get('event-calendar', [PublicEventController::class, 'index'])->name('event.index');
        Route::get('event/{slug}', [PublicEventController::class, 'show'])->name('event.show');
        /* Events END */
    }
);
/* Public routes END */


/* Routes only for authenticated users */
Route::group(
    ['middleware' => ['web', 'auth', 'verified', '2fa', 'role:super-administrator|administrator'], 'prefix' => 'admin'],
    function () {
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
/* Routes only for authenticated users END */
