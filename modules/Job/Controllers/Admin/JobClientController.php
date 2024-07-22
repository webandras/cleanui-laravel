<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Auth\Traits\UserPermissions;
use Modules\Job\Enums\ClientType;
use Modules\Job\Models\Client;

class JobClientController extends Controller
{
    use UserPermissions;

    /**
     * Display a listing of the resource.
     *
     * @returns View|\Illuminate\Foundation\Application|Factory|Application
     * @throws AuthorizationException
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->authorize('viewAny', Client::class);

        $types = ClientType::options();
        $clients = Client::paginatedClients();

        return view('job::admin.client.manage')->with([
            'clients' => $clients,
            'clientTypes' => $types,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
