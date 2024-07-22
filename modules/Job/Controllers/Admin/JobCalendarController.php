<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Job\Models\Job;

class JobCalendarController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return View|\Illuminate\Foundation\Application|Factory|Application
     * @throws AuthorizationException
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->authorize('viewAny', Job::class);

        return view('job::admin.job.calendar');
    }

}
