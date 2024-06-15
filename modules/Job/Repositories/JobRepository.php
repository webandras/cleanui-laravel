<?php

namespace Modules\Job\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Interfaces\JobRepositoryInterface;
use Modules\Job\Models\Job;

class JobRepository implements JobRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getJobs(): Collection
    {
        return Job::with(['workers'])->with([
            'client' => function ($query) {
                $query->withTrashed();
            }
        ])->get();
    }


    /**
     * @param  int  $jobId
     * @return Model
     */
    public function getJobById(int $jobId): Model
    {
        return Job::with(['workers'])->with([
            'client' => function ($query) {
                $query->withTrashed();
            }
        ])->where('id', '=', $jobId)->first();
    }


    /**
     * @param  Job  $job
     * @param  array  $data
     * @param  array  $workerIds
     * @return Job
     */
    public function updateJob(Job $job, array $data, array $workerIds): Job
    {
        $job->update($data);
        $job->workers()->sync($workerIds);
        return $job;
    }


    /**
     * @param  array  $data
     * @param  array  $workerIds
     * @return Job
     */
    public function createJob(array $data, array $workerIds): Job
    {
        //dd($data);
        $job = Job::create($data);
        $job->workers()->sync($workerIds);
        return $job;
    }


    /**
     * @param  Job  $job
     * @return void
     */
    public function deleteJob(Job $job): void
    {
        $job->delete();
    }

}
