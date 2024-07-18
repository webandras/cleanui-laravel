<?php

namespace Modules\Job\Actions\Job;

use Modules\Job\Models\Job;

class UpdateJob
{
    public function __invoke(Job $job, array $data, array $workerIds): Job
    {
        $job->update($data);
        $job->workers()->sync($workerIds);
        return $job;
    }
}
