<?php

namespace App\Repository\Job;

use App\Interface\Repository\Job\WorkerRepositoryInterface;
use App\Models\Job\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WorkerRepository implements WorkerRepositoryInterface
{

    public function getPaginatedWorkers(): LengthAwarePaginator
    {
        return Worker::orderBy('created_at', 'DESC')
            ->paginate(Worker::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    public function getAllWorkers(): Collection
    {
        return Worker::all();
    }

}
