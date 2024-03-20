<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;

class JobCalendarController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.pages.job.calendar');
    }

}
