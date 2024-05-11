<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Interface\Entities\Event\OrganizerInterface;
use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Organizer;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;

class OrganizerController extends Controller
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
        $this->authorize('viewAny', Organizer::class);

        $organizers = $this->modelRepository->paginateEntities('Event\Organizer', OrganizerInterface::RECORDS_PER_PAGE);

        return view('admin.pages.organizer.manage')->with([
            'organizers' => $organizers,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }
}
