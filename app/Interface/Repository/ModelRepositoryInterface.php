<?php

namespace App\Interface\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelRepositoryInterface
{

    /**
     * @param  string  $modelClass
     * @param  int  $perPage
     * @return LengthAwarePaginator
     */
    public function paginateEntities(string $modelClass, int $perPage): LengthAwarePaginator;


    /**
     * @param  string  $modelClass
     * @param  array  $data
     * @return Model
     */
    public function createEntity(string $modelClass, array $data): Model;


    /**
     * @param  Model  $model
     * @return bool
     */
    public function deleteEntity(Model $model): bool;


    /**
     * @param  Model  $model
     * @param  array  $data
     * @return bool
     */
    public function updateEntity(Model $model, array $data): bool;

}
