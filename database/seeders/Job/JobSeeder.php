<?php

namespace Database\Seeders\Job;

use DateTimeInterface;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\Job\Models\Job;
use Modules\Job\Models\Worker;

class JobSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private \Faker\Generator $faker;


    /**
     *
     */
    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $format = 'Y-m-d H:i:s';
        $currentDateTime = (new \DateTime('now', new \DateTimeZone('UTC')))->setTime(9, 0);

        Job::insert([
            [
                'id'          => 1,
                'client_id'   => 1,
                'start'       => $currentDateTime->format($format),
                'end'         => ($currentDateTime->modify('+3 hours'))->format($format),
                'description' => 'etiam elit eget natum deseruisse offendit',
                'status'      => 'opened',
            ],

            [
                'id'          => 2,
                'client_id'   => 2,
                'start'       => ($currentDateTime->modify('+1 days -6 hours'))->format($format),
                'end'         => ($currentDateTime->modify('+4 hours'))->format($format),
                'description' => 'netus erroribus autem ridiculus idque fermentum',
                'status'      => 'opened',
            ],

            [
                'id'          => 3,
                'client_id'   => 3,
                'start'       => ($currentDateTime->modify('+1 days -5 hours'))->format(DateTimeInterface::ATOM),
                'end'         => ($currentDateTime->modify('+5 hours'))->format(DateTimeInterface::ATOM),
                'description' => 'necessitatibus interdum voluptatibus magna nominavi delenit',
                'status'      => 'completed',
            ],
        ]);


        // Create workers, attach them to jobs
        Worker::factory(3)->create();
        $workers = Worker::all();

        foreach ($workers as $worker) {
            $jobIds = $this->getJobIds();
            if ( ! empty($jobIds)) {
                $worker->jobs()->attach($jobIds);
            }
        }
    }


    /**
     * @return array
     */
    private function getJobIds(): array
    {
        return $this->faker->randomElements([1, 2, 3], $this->faker->numberBetween(0, 3));
    }
}
