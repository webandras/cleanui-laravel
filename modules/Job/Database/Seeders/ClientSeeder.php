<?php

namespace Modules\Job\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\Job\Models\Client;
use Modules\Job\Models\ClientDetail;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Create clients and client details for them */
        ClientDetail::factory(3)->create()->each(function($clientDetail) {
            $now = Carbon::now('utc')->toDateTimeString();
            Client::factory()->create([
                'client_detail_id' => $clientDetail->id,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
        });
    }
}
