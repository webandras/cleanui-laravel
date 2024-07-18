<?php

namespace Modules\Job\Actions\Client;

use Modules\Job\Models\Client;

class DeleteClient
{
    public function __invoke(Client $client): bool
    {
        $client->delete();
        $client->client_detail()->delete();
        return true;
    }
}
