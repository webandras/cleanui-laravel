<?php

namespace Database\Seeders\Job;

use App\Models\Job\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Job::insert([
            [
                'id' => 1,
                'start' => '2024-03-20',
                'end'   => null,
                'description' => 'etiam elit eget natum deseruisse offendit',
                'status' => 'opened',
            ],

            [
                'id' => 2,
                'start' => '2024-03-21T08:00:00',
                'end'   => '2024-03-21T16:00:00',
                'description' => 'netus erroribus autem ridiculus idque fermentum',
                'status' => 'opened',
            ],

            [
                'id' => 3,
                'start' => '2024-03-23',
                'end'   => '2024-03-25',
                'description' => 'necessitatibus interdum voluptatibus magna nominavi delenit',
                'status' => 'completed',
            ]
        ]);

    }
}
