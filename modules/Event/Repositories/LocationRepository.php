<?php

namespace Modules\Event\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Event\Interfaces\Entities\LocationInterface;
use Modules\Event\Interfaces\Repositories\LocationRepositoryInterface;
use Modules\Event\Models\Location;

/**
 * Manage locations CRUD
 */
class LocationRepository implements LocationRepositoryInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function paginateLocations(): LengthAwarePaginator
    {
        return Location::paginate(LocationInterface::RECORDS_PER_PAGE);
    }


    /**
     * @param  array  $data
     * @return bool
     */
    public function createLocation(array $data): bool
    {
        return Location::create($data);
    }


    /**
     * @param  Location  $location
     * @return bool
     * @throws \Throwable
     */
    public function deleteLocation(Location $location): bool
    {
        return $location->deleteOrFail();
    }


    /**
     * @param  Location  $location
     * @param  array  $data
     * @return bool
     * @throws \Throwable
     */
    public function updateLocation(Location $location, array $data): bool
    {
        return $location->updateOrFail($data);
    }
}
