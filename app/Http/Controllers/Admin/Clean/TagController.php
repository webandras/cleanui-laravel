<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TagController extends Controller
{

    /**
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        return view('admin.pages.tag.manage');
    }

}
