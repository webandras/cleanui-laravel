<?php

namespace Modules\Job\Actions\Job;

use Modules\Job\Models\Job;

class DeleteJob
{
    public function __invoke(Job $job): bool
    {
        $job->delete();
        return true;
    }
}
