<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Job\Models\Worker;

class JobWorkerController extends Controller
{
    use InteractsWithBanner, UserPermissions;


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
       $this->authorize('viewAny', Worker::class);

        return view('admin.pages.job.worker.manage')->with([
            'workers' => Worker::paginatedWorkers(),
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
