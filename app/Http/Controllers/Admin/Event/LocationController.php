<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Interface\Entities\Event\LocationInterface;
use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Clean\User;

class LocationController extends Controller
{

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
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $locations = $this->modelRepository->paginateEntities('Event\Location',
            LocationInterface::RECORDS_PER_PAGE);

        return view('admin.pages.location.manage')->with([
            'locations' => $locations
        ]);
    }
}
