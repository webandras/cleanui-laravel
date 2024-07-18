<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Modules\Auth\Traits\UserPermissions;
use Modules\Job\Enums\ClientType;
use Modules\Job\Models\Client;

class JobClientController extends Controller
{
    use UserPermissions;

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);

        $types = ClientType::options();
        $clients = Client::paginatedClients();

        return view('admin.pages.job.client.manage')->with([
            'clients' => $clients,
            'clientTypes' => $types,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
