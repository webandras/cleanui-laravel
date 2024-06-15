<?php

namespace Modules\Demo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Auth\Traits\UserPermissions;

class DemoController extends Controller
{
    use UserPermissions;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('admin.pages.demo')->with([
            'fruits' => [
                'Apple', 'Banana', 'Watermelon', 'Orange', 'Cherry', 'Blackberry', 'Strawberry', 'Apricot', 'Kiwi',
            ],
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
