<?php

namespace App\Http\Controllers\Event\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Event\Interfaces\Entities\LocationInterface;
use Modules\Event\Models\Location;

class LocationController extends Controller
{
    use UserPermissions;

    /**
     * @var ModelRepositoryInterface
     */
    private ModelRepositoryInterface $modelRepository;


    /**
     * @param  ModelRepositoryInterface  $modelRepository
     */
    public function __construct(ModelRepositoryInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Location::class);

        $locations = $this->modelRepository->paginateEntities('Event\Location',
            LocationInterface::RECORDS_PER_PAGE);

        return view('admin.pages.location.manage')->with([
            'locations' => $locations,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
