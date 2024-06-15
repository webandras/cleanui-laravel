<?php

namespace Modules\Job\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Job\Models\CLient;

interface ClientRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getAllClients(): Collection;

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedClients(): LengthAwarePaginator;


    /**
     * @return array
     */
    public function getClientTypes(): array;


    /**
     * @param  array  $client
     * @param  array  $details
     * @return Client
     */
    public function createClient(array $client, array $details): Client;


    /**
     * @param  Client  $client
     * @param  array  $clientData
     * @param  array  $detailsData
     * @param  int|null  $clientDetailId
     * @return bool|null
     */
    public function updateClient(Client $client, array $clientData, array $detailsData, ?int $clientDetailId = null): bool|null;


    /**
     * @param  Client  $client
     * @return bool|null
     */
    public function deleteClient(Client $client): bool|null;
}
