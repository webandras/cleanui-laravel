<?php

namespace App\Repository;

use App\Interface\Repository\ModelRepositoryInterface;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Manage entity CRUD
 */
class ModelRepository implements ModelRepositoryInterface
{

    /**
     * @param  string  $modelClass
     * @param  int  $perPage
     * @return LengthAwarePaginator
     */
    public function paginateEntities(string $modelClass, int $perPage): LengthAwarePaginator
    {
        if (!class_exists($modelClass)) {
            throw new InvalidArgumentException();
        }
        return $modelClass::paginate($perPage);
    }


    /**
     * @param  string  $modelClass
     * @param  array  $data
     * @return Model
     */
    public function createEntity(string $modelClass, array $data): Model
    {
        if (!class_exists($modelClass)) {
            throw new InvalidArgumentException();
        }

        return $modelClass::create($data);
    }


    /**
     * @param  Model  $model
     * @return bool
     * @throws \Throwable
     */
    public function deleteEntity(Model $model): bool
    {
        return $model->deleteOrFail();

    }


    /**
     * @param  Model  $model
     * @param  array  $data
     * @return bool
     * @throws \Throwable
     */
    public function updateEntity(Model $model, array $data): bool
    {
        return $model->updateOrFail($data);
    }
}
