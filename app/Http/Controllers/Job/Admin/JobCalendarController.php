<?php

namespace App\Http\Controllers\Job\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Job\Models\Job;

class JobCalendarController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Job::class);

        return view('admin.pages.job.calendar');
    }

}
