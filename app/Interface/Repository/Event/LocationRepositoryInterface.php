<?php

namespace App\Interface\Repository\Event;

use App\Models\Event\Location;
use Illuminate\Pagination\LengthAwarePaginator;

interface LocationRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function paginateLocations(): LengthAwarePaginator;


    /**
     * @param  array  $data
     * @return bool
     */
    public function createLocation(array $data): bool;


    /**
     * @param  Location  $location
     * @return bool
     */
    public function deleteLocation(Location $location): bool;


    /**
     * @param  Location  $location
     * @param  array  $data
     * @return bool
     */
    public function updateLocation(Location $location, array $data): bool;

}
