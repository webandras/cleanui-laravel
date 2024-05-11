<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;
use App\Models\Job\Job;
use Illuminate\Auth\Access\AuthorizationException;

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
