<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;
use App\Interface\Repository\Job\ClientRepositoryInterface;
use App\Models\Job\Client;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;

class JobClientController extends Controller
{
    use UserPermissions;

    /**
     * @var ClientRepositoryInterface
     */
    public ClientRepositoryInterface $clientRepository;


    /**
     *
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);

        $types = $this->clientRepository->getClientTypes();
        $clients = $this->clientRepository->getPaginatedClients();


        return view('admin.pages.job.client.manage')->with([
            'clients' => $clients,
            'clientTypes' => $types,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
