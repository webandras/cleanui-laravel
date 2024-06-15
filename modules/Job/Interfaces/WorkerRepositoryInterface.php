<?php

namespace Modules\Job\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface WorkerRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedWorkers(): LengthAwarePaginator;


    /**
     * @return Collection
     */
    public function getAllWorkers(): Collection;

}
