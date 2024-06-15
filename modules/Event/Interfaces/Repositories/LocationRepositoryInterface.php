<?php

namespace Modules\Event\Interfaces\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Event\Models\Location;

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
