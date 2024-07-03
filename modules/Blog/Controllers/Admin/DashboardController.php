<?php

namespace Modules\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Traits\InteractsWithBanner;


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
