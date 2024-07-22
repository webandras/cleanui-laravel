<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Job\Models\Job;

class JobStatsController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * Admin dashboard page
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(): Application|Factory|View
    {
        $this->authorize('viewAny', Job::class);

        return view('job::admin.job.statistics')->with([
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
