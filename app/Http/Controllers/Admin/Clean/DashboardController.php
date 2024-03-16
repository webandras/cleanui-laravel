<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class DashboardController extends Controller
{
    use InteractsWithBanner;

    /**
     * Admin dashboard page
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('admin.pages.dashboard');
    }
}
