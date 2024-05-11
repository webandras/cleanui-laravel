<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use App\Models\Clean\Tag;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TagController extends Controller
{
    use UserPermissions;


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(): Factory|View|Application
    {
        $this->authorize('viewAny', Tag::class);

        return view('admin.pages.tag.manage')->with([
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }

}
