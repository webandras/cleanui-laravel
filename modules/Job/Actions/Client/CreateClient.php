<?php

namespace Modules\Job\Actions\Client;

use Modules\Job\Models\Client;
use Modules\Job\Models\ClientDetail;

class CreateClient
{
    public function __invoke(array $client, array $details): Client
    {
        if (!empty($details)) {
            // we need to create a new ClientDetail record
            $newClientDetails = new ClientDetail($details);
            $newClientDetails->save();

            // refresh data
            $newClientDetails->refresh();
        }

        // store the client detail id
        $newClient = Client::create(array_merge($client, ['client_detail_id' => $newClientDetails->id ?? null]));
        $newClient->save();

        return $newClient;
    }
}
