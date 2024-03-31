<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Interface\Entities\Event\OrganizerInterface;
use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Organizer;

class OrganizerController extends Controller
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
        $this->authorize('viewAny', Organizer::class);

        $organizers = $this->modelRepository->paginateEntities('Event\Organizer', OrganizerInterface::RECORDS_PER_PAGE);

        return view('admin.pages.organizer.manage')->with([
            'organizers' => $organizers
        ]);
    }
}
