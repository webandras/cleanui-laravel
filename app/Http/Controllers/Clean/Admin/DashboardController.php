<?php

namespace App\Http\Controllers\Clean\Admin;

use App\Http\Controllers\Controller;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Auth\Traits\UserPermissions;


class DashboardController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * Admin dashboard page
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        return view('admin.pages.dashboard')->with([
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
