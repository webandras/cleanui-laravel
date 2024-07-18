<?php

namespace Modules\Job\Actions\Job;

use Modules\Job\Models\Job;

class CreateJob
{
    public function __invoke(array $data, array $workerIds): Job
    {
        $job = Job::create($data);
        $job->workers()->sync($workerIds);
        return $job;
    }
}
