<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;
use App\Models\Job\Job;
use App\Trait\Clean\InteractsWithBanner;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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

        return view('admin.pages.job.statistics')->with([
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
