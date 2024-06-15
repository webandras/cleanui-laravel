<?php

namespace Modules\Job\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Auth\Traits\UserPermissions;
use Modules\Job\Interfaces\WorkerRepositoryInterface;
use Modules\Job\Models\Worker;

class JobWorkerController extends Controller
{
    use InteractsWithBanner, UserPermissions;


    /**
     * @var WorkerRepositoryInterface
     */
    private WorkerRepositoryInterface $workerRepository;


    /**
     * @param  WorkerRepositoryInterface  $workerRepository
     */
    public function __construct(WorkerRepositoryInterface $workerRepository)
    {
        $this->workerRepository = $workerRepository;
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
       $this->authorize('viewAny', Worker::class);

        return view('admin.pages.job.worker.manage')->with([
            'workers' => $this->workerRepository->getPaginatedWorkers(),
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
