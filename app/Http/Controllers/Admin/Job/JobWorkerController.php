<?php

namespace App\Http\Controllers\Admin\Job;

use App\Http\Controllers\Controller;
use App\Interface\Repository\Job\WorkerRepositoryInterface;
use App\Models\Clean\User;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class JobWorkerController extends Controller
{
    use InteractsWithBanner;


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
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('viewAny', User::class);

        return view('admin.pages.job.worker.manage')->with([
            'workers' => $this->workerRepository->getPaginatedWorkers(),
        ]);
    }

}
