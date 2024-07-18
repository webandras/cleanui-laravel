<?php

namespace Modules\Job\Actions\Client;

use Modules\Job\Models\Client;
use Modules\Job\Models\ClientDetail;

class UpdateClient
{
    public function __invoke(Client $client, array $clientData, array $detailsData, ?int $clientDetailId = null): Client
    {
        // if user sets detail fields and we don't have a client detail record yet
        if (!empty($detailsData) && $clientDetailId === null) {

            $detailsData['client_id'] = $client->id;
            $newClientDetails = new ClientDetail($detailsData);
            $newClientDetails->save();

            // refresh properties
            $newClientDetails->refresh();

            // set client detail id for the client to be saved
            $clientData['client_detail_id'] = $newClientDetails->id;

        } else {
            $client->client_detail()->update($detailsData);
        }

        $client->update($clientData);

        return $client;
    }
}
