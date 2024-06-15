<?php

namespace Modules\Job\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Job\Interfaces\WorkerRepositoryInterface;
use Modules\Job\Models\Worker;

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
