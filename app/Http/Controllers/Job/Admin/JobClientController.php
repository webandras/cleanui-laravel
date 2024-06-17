<?php

namespace App\Http\Controllers\Job\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Auth\Traits\UserPermissions;
use Modules\Job\Interfaces\ClientRepositoryInterface;
use Modules\Job\Models\Client;

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
