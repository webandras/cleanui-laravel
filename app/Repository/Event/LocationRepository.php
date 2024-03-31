<?php

namespace App\Repository\Event;

use App\Interface\Entities\Event\LocationInterface;
use App\Interface\Repository\Event\LocationRepositoryInterface;
use App\Models\Event\Location;
use Illuminate\Pagination\LengthAwarePaginator;

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
