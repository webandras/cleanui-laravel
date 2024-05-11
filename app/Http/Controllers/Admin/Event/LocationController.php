<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Interface\Entities\Event\LocationInterface;
use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Location;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;

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
