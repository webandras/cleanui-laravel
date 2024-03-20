<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;
use App\Interface\Repository\Job\ClientRepositoryInterface;
use App\Models\Clean\User;

class JobClientController extends Controller
{

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
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $types = $this->clientRepository->getClientTypes();
        $clients = $this->clientRepository->getPaginatedClients();


        return view('admin.pages.job.client.manage')->with([
            'clients' => $clients,
            'clientTypes' => $types
        ]);
    }

}
