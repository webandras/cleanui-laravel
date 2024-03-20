<?php

namespace App\Interface\Repository\Job;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
