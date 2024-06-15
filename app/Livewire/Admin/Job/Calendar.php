<?php

namespace App\Livewire\Admin\Job;

use App\Trait\Clean\InteractsWithBanner;
use DateTimeInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Interfaces\Services\DateTimeServiceInterface;
use Modules\Job\Interfaces\ClientRepositoryInterface;
use Modules\Job\Interfaces\JobRepositoryInterface;
use Modules\Job\Models\Job;
use Modules\Job\Models\Worker;

class Calendar extends Component
{
    use InteractsWithBanner;

    // used by blade / alpinejs
    /**
     * @var string
     */
    public string $modalId;


    /**
     * @var string
     */
    public string $deleteModalId;


    /**
     * @var bool
     */
    public bool $isModalOpen;


    /**
     * @var bool
     */
    public bool $isDeleteModalOpen;


    // inputs
    /**
     * id for new job
     *
     * @var int|null
     */
    public ?int $newId;


    /**
     * id for existing job
     *
     * @var int|null
     */
    public ?int $updateId;


    /**
     * Job model entity
     *
     * @var
     */
    public $job;


    /**
     * start and end is for regular jobs
     * @var string
     */
    public string $start;


    /**
     * @var string|null
     */
    public ?string $end;


    /**
     * @var int
     */
    public int $isRecurring;


    /**
     * @var string
     */
    public string $duration;


    // basic job properties
    // all types of jobs can have these props
    /**
     * @var string
     */
    public string $description;


    /**
     * @var string
     */
    public string $status;


    /**
     * @var string|null
     */
    public ?string $backgroundColor;


    /**
     * @var array
     */
    public array $statusArray;


    /**
     * @var Collection
     */
    public Collection $workers;


    /**
     * @var array
     */
    public array $workerIds;


    /**
     * @var array
     */
    public array $statusColors;


    /**
     * @var int|null
     */
    public ?int $clientId;


    /**
     * @var Collection
     */
    public Collection $clients;


    /**
     * @var string
     */
    public string $clientName;


    /**
     * @var string
     */
    public string $clientAddress;


    // for recurring jobs (by recurrence rules)
    /**
     * @var string
     */
    private string $frequency;


    /**
     * @var array
     */
    public array $frequencies;


    /**
     * @var string
     */
    public string $frequencyName;


    /**
     * @var string
     */
    public string $dtstart;


    /**
     * @var string
     */
    public string $until;


    /**
     * @var string
     */
    public string $byweekday;


    /**
     * @var array
     */
    public array $weekDays;


    /**
     * @var int
     */
    private int $interval;


    /**
     * @var array
     */
    public array $rrule;


    /**
     * @var string
     */
    public string $timezone;


    // Job list as collection
    /**
     * @var Collection
     */
    public Collection $jobs;


    /**
     * @var JobRepositoryInterface
     */
    private JobRepositoryInterface $jobRepository;


    /**
     * @var ClientRepositoryInterface
     */
    private ClientRepositoryInterface $clientRepository;


    /**
     * @var DateTimeServiceInterface
     */
    private DateTimeServiceInterface $dateTimeService;


    /**
     * dynamically set rules based on job type (recurring or regular)
     * @return array[]
     */
    protected function rules(): array
    {
        // shared property validation rules
        $rules = [
            'updateId' => ['nullable', 'integer', 'min:1'],
            'workerIds' => ['array'],
            'clientId' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ];

        // non-recurring
        if ($this->isRecurring === 0) {
            $rules['start'] = ['required', 'string', 'max:255'];
            $rules['end'] = ['nullable', 'string', 'max:255'];

        } else {
            // recurring
            $rules['frequencyName'] = ['required', 'string'];
            $rules['byweekday'] = ['required', 'string'];
            $rules['dtstart'] = ['required', 'string'];
            $rules['until'] = ['nullable', 'string'];
            $rules['duration'] = ['required', 'string'];

        }
        return $rules;

    }


    /**
     * listen to frontend calendar jobs, bind them with backend methods with Livewire (ajax requests)
     *
     * @var string[]
     */
    protected $listeners = [
        'deleteJobListener' => 'deleteJob',
        'openDeleteJobModal' => 'openDeleteJobModal',
        'closeJobModal' => 'closeJobModal',
    ];


    /**
     * @param  JobRepositoryInterface  $jobRepository
     * @param  ClientRepositoryInterface  $clientRepository
     * @param  DateTimeServiceInterface  $dateTimeService
     * @return void
     */
    public function boot(
        JobRepositoryInterface $jobRepository,
        ClientRepositoryInterface $clientRepository,
        DateTimeServiceInterface $dateTimeService
    ): void {
        $this->jobRepository = $jobRepository;
        $this->clientRepository = $clientRepository;
        $this->dateTimeService = $dateTimeService;
    }


    /**
     * Mount life-cycle hook of the livewire component
     * @return void
     */
    public function mount(): void
    {
        $this->initializeProperties();
        $this->workers = Worker::all();
    }


    /**
     * @return void
     */
    public function updatedIsModalOpen(): void
    {
        $this->initializeProperties();
    }

    /**
     * @return void
     */
    public function initializeProperties(): void
    {
        // Alpine
        $this->modalId = 'job-modal';
        $this->deleteModalId = 'delete-job-modal';
        $this->isDeleteModalOpen = false;
        $this->isModalOpen = false;
        $this->isRecurring = 0;

        // Entity properties init
        $this->start = '';
        $this->end = null;
        $this->description = '';
        $this->status = 'opened';
        $this->backgroundColor = null;
        $this->byweekday = '';
        $this->frequencyName = '';
        $this->dtstart = '';
        $this->until = '';
        $this->rrule = [];
        $this->duration = '';
        $this->interval = 1;

        //
        $this->allDay = false;
        $this->newId = null;
        $this->updateId = null;
        $this->job = null;
        $this->clientId = null;
        $this->clientName = '';
        $this->clientAddress = '';

        // statuses
        $this->statusArray = [
            'pending' => 'Pending',
            'opened' => 'Opened',
            'completed' => 'Completed',
            'closed' => 'Closed'
        ];

        // weekdays
        $this->weekDays = [
            __('Sunday') => 'Su',
            __('Monday') => 'Mo',
            __('Tuesday') => 'Tu',
            __('Wednesday') => 'We',
            __('Thursday') => 'Th',
            __('Friday') => 'Fr',
            __('Saturday') => 'Sa',
        ];

        // bi-weekly or other recurrences can be created by setting the interval property (interval=2 -> every second week/month...)
        $this->frequencies = [
            'Hetente' => 'weekly',
            'Kéthetente' => '2-weekly',
            'Háromhetente' => '3-weekly',
            'Négyhetente' => '4-weekly'
        ];

        $this->workerIds = [];

        // default background color palette by statuses
        $this->statusColors = [
            'pending' => '#025370',
            'opened' => '#c90000',
            'completed' => '#0f5d2a',
            'closed' => '#62626b'
        ];

        $this->clients = $this->clientRepository->getAllClients();

        $this->timezone = auth()->user()->preferences->timezone ?? 'UTC';
    }


    /**
     * @return Application|Factory|View
     */
    public function render(): View|Factory|Application
    {
        /* Also query soft-deleted clients (needed for the job view) */
        $this->jobs = $this->jobRepository->getJobs();

        return view('admin.livewire.job.calendar');
    }


    /**
     * @param $job
     *
     * @return RedirectResponse|void
     * @throws \Exception
     */
    public function jobChange($job)
    {
        $changedJob = null;

        foreach ($this->jobs as $singleJob) {
            if ($singleJob->id === (int) $job['id']) {
                $changedJob = $singleJob;
            }
        }

        if ($changedJob === null) {
            $this->banner(__('Job does not exists!'), 'danger');

            return redirect()->route('job.calendar');
        }


        if (!$changedJob->is_recurring) {
            // input 'Y-m-d\TH:i:sP', output: 'Y-m-d H:i:s'
            $changedJob->start = $this->dateTimeService->convertFromLocalToUtc($job['start'], Job::TIMEZONE,
                false,
                DateTimeInterface::ATOM);

            if (Arr::exists($job, 'end')) {
                // input 'Y-m-d\TH:i:sP', output: 'Y-m-d H:i:s'
                $changedJob->end = $this->dateTimeService->convertFromLocalToUtc($job['end'], Job::TIMEZONE,
                    false,
                    DateTimeInterface::ATOM);
            }
            $changedJob->save();

        } else {
            // always use the uuid column here (which is the 'id')!
            $jobId = $changedJob->id;
            $this->updateId = (int) $jobId;
            $this->job = $this->jobRepository->getJobById($jobId);

            if ($this->checkIfJobExists() === null) {
                $this->banner(__('Job does not exists!'), 'danger');
                return redirect()->route('job.calendar');
            }

            // Update the time part only
            // otherwise it would change the start date of the recurring job
            $newRules = $this->job->rrule;

            // input 'Y-m-d\TH:i:s', output: 'Y-m-d H:i:s'
            $newRules['dtstart'] = $this->dateTimeService->convertFromLocalToUtc($job['start'], Job::TIMEZONE,
                false,
                DateTimeInterface::ATOM, 'Y-m-d\TH:i:s\Z');

            // On resize, overwrite the duration field (the right way with DateTime class etc.)
            if (Arr::exists($job, 'start') && Arr::exists($job, 'end')) {

                // input 'Y-m-d H:i:s', output: 'Y-m-d H:i:s'
                $start = Job::convertFromLocalToUtc($job['start'], Job::TIMEZONE, true);

                if ($start === false) {
                    $start = Job::convertFromLocalToUtc($job['start'], Job::TIMEZONE, true, 'Y-m-d\\TH:i:sP');
                }

                // input 'Y-m-d H:i:s', output: 'Y-m-d H:i:s'
                $end = Job::convertFromLocalToUtc($job['end'], Job::TIMEZONE, true);

                if ($end === false) {
                    $end = Job::convertFromLocalToUtc($job['end'], Job::TIMEZONE, true, 'Y-m-d\\TH:i:sP');
                }

                $difference = $end->diff($start);
                $newDuration = $difference->format("%H:%I:%S");
                $this->job->duration = $newDuration;

                // change weekday if we moved the job to another day of the week
                $newRules['byweekday'] = substr($start->format('D'), 0, -1);
            }

            $this->job->rrule = $newRules;
            $this->job->save();
        }

    }


    /**
     * Opens modal, fills up livewire class properties for the form modal
     *
     * @param  array  $args
     *
     * @return RedirectResponse|void
     * @throws \Exception
     */
    public function jobModal(array $args)
    {

        // existing job update
        if (array_key_exists('event', $args)) {
            $args = $args['event'];
            $this->updateId = (int) $args['id'];
            $this->setCurrentJob();

            if ($this->checkIfJobExists() === null) {
                $this->banner(__('Job does not exists!'), 'danger');

                return redirect()->route('job.calendar');
            }

            $this->initializeExistingPropertiesForModal();
        }

        $this->initializePropertiesFromArgs($args);
    }


    /**
     * Create new or update existing job
     *
     * @return Redirector
     */
    public function createOrUpdateJob(): Redirector
    {
        $this->validate();

        DB::transaction(
            function () {

                // all job have these
                $jobProps = [
                    'description' => $this->description,
                ];

                // if we have an id, update existing job
                if (isset($this->updateId)) {

                    $jobEntity = $this->getCurrentJob();
                    if ($jobEntity === null) {
                        $this->banner(__('Job does not exists!'), 'danger');

                        return redirect()->route('job.calendar');
                    }

                    $this->setJobProperties($jobProps);

                    $jobEntity = $this->jobRepository->updateJob($jobEntity, $jobProps, $this->workerIds);
                    $jobEntity->save();
                    // refresh would also refresh relations, but client will be null here, because
                    // it does not query trashed (soft-deleted) clients as relations
                    // $jobEntity->refresh();

                    $this->banner(__('Successfully updated the job ":name"!',
                        ['name' => htmlspecialchars($jobEntity->client->name)]));
                } else {
                    $this->setJobProperties($jobProps);

                    $jobEntity = $this->jobRepository->createJob($jobProps, $this->workerIds);
                    $jobEntity->save();
                    // $jobEntity->refresh();

                    $this->banner(__('Successfully created the job ":name"!',
                        ['name' => htmlspecialchars($jobEntity->client->name)]));
                }
            },
            2
        );

        // Need to clear previous job data
        $this->initializeProperties();
        return redirect()->route('job.calendar');
    }


    /**
     * Delete the selected job
     *
     * @return Redirector|null
     */
    public function deleteJob(): ?Redirector
    {

        // if we have an id, delete existing job
        if (isset($this->updateId)) {

            $job = $this->getCurrentJob();
            if ($job === null) {
                $this->banner(__('Job does not exists!'), 'danger');
                return redirect()->route('job.calendar');
            }

            $title = $job->client->name;

            // delete role, rollback transaction if fails
            DB::transaction(
                function () use ($job) {
                    $this->jobRepository->deleteJob($job);
                },
                2
            );

            // reset loaded job properties for the modal
            $this->initializeProperties();

            $this->banner(__('Successfully deleted the job ":name"!', ['name' => htmlspecialchars($title)]));
        }

        return redirect()->route('job.calendar');
    }


    /**
     * Show delete modal
     *
     * @return void
     */
    public function openDeleteJobModal(): void
    {
        $this->isDeleteModalOpen = true;
    }


    /**
     * Reset selected job properties when closing the modal
     * @return void
     */
    public function closeJobModal(): void
    {
        $this->initializeProperties();
    }


    /**
     * Check if the job is properly loaded / exists
     * @return bool
     */
    private function checkIfJobExists(): bool
    {
        return $this->job === null;
    }


    /**
     * Set the recurring / normal job-specific properties
     *
     * @param $jobProps
     *
     * @return void
     * @throws \Exception
     */
    private function setJobProperties(&$jobProps): void
    {
        // recurring job props
        if ($this->isRecurring === 1) {
            $jobProps['is_recurring'] = 1;

            if ($this->byweekday !== '') {
                $this->rrule['byweekday'] = $this->byweekday;
            }

            $this->setFrequencyNameAndInterval();

            $this->rrule['freq'] = $this->frequencyName;
            $this->rrule['interval'] = $this->interval;


            if ($this->dtstart !== '') {
                // Fullcalendar returns inconsistent formats. FUCK YOU fullcalendar!
                // The format can be either 'Y-m-d H:i:s', or 'Y-m-d\TH:i'
                // Datetime need to be saved with the letters T and Z, so that it is recognized by fullcalendar as UTC,
                // and will be converted to local timezone using moment.js
                $this->rrule['dtstart'] = $this->dateTimeService->convertFromLocalToUtc($this->dtstart, Job::TIMEZONE,
                    false,
                    'Y-m-d H:i:s', 'Y-m-d\TH:i:s\Z');


                if ($this->rrule['dtstart'] === false) {
                    $this->rrule['dtstart'] = $this->dateTimeService->convertFromLocalToUtc($this->dtstart,
                        Job::TIMEZONE, false,
                        'Y-m-d\TH:i', 'Y-m-d\TH:i:s\Z');
                }
            }

            if ($this->until !== '') {
                $this->rrule['until'] = $this->until;
            }

            if ($this->duration !== '') {
                $jobProps['duration'] = $this->duration;
            }

            if (!empty($this->rrule)) {
                $jobProps['rrule'] = $this->rrule;
            }
        } else {
            // regular jobs; input YYYY-MM-DDThh:mm, output: 'Y-m-d H:i:s'
            $jobProps['start'] = $this->dateTimeService->convertFromLocalToUtc($this->dateTimeService->transformDateTimeLocalInput($this->start), Job::TIMEZONE);
            // input 'Y-m-d H:i:s', output: 'Y-m-d H:i:s'
            $jobProps['end'] = $this->dateTimeService->convertFromLocalToUtc($this->dateTimeService->transformDateTimeLocalInput($this->end), Job::TIMEZONE);
        }

        // If a client need to be associated with the job
        if ($this->clientId !== 0) {
            // color is from status or it is custom
            $jobProps['client_id'] = $this->clientId;
        }

    }


    /**
     * Set current job for the modal
     *
     * @return void
     */
    private function setCurrentJob(): void
    {
        foreach ($this->jobs as $job) {
            if ($job->id === (int) $this->updateId) {
                $this->job = $this->jobRepository->getJobById($this->updateId);
                break;
            }
        }
    }


    /**
     * Get current job and return the entity
     *
     * @return Model|Job|null
     */
    private function getCurrentJob(): Model|Job|null
    {
        foreach ($this->jobs as $job) {
            if ($job->id === (int) $this->updateId) {
                return $this->jobRepository->getJobById($this->updateId);
            }
        }

        return null;
    }


    /**
     * Get the color from the default palette (based on the job status)
     * @return string|null
     */
    private function getBackgroundColorFromStatus(): ?string
    {
        foreach ($this->statusColors as $key => $value) {
            if ($this->status === $key) {
                return $value;
            }
        }
        return null;
    }


    /**
     * Check if the user-supplied color is different from the default status colors
     * @return bool
     */
    private function isBackgroundColorCustom(): bool
    {
        foreach ($this->statusColors as $key => $value) {
            if ($this->backgroundColor === $value) {
                return false;
            }
        }

        return true;
    }


    /**
     * Initialize properties from job object for the modal
     * @return void
     * @throws \Exception
     */
    private function initializeExistingPropertiesForModal(): void
    {
        $this->workerIds = $this->job
            ->workers()
            ->get()
            ->pluck(['id'])
            ->toArray();

        $this->description = $this->job->description;
        $this->frequencyName = $this->job->rrule['freq'] ?? '';
        $this->byweekday = $this->job->rrule['byweekday'] ?? '';
        $this->until = $this->job->rrule['until'] ?? '';
        $this->interval = $this->job->rrule['interval'] ?? 1;
        $this->duration = $this->job->duration ?? '';
        $this->isRecurring = $this->job->is_recurring ?? 0;
        $this->clientId = 0;

        if (isset($this->job->rrule['dtstart'])) {
            // input 'Y-m-d\TH:i:s\Z', output: 'Y-m-d H:i:s'
            $this->dtstart = $this->dateTimeService->convertFromUtcToLocal($this->job->rrule['dtstart'],
                Job::TIMEZONE, false,
                'Y-m-d\TH:i:s\Z');
        } else {
            $this->dtstart = '';
        }

        $this->setFrequencyName();

        if (isset($this->job->client)) {
            $this->clientId = $this->job->client->id;
            $this->clientName = $this->job->client->name;
            $this->clientAddress = $this->job->client->address;
        }
    }


    /**
     * Initialize properties for modal from arguments coming from client-side (from FullCalendar)
     *
     * @param  array  $args
     *
     * @return void
     * @throws \Exception
     */
    private function initializePropertiesFromArgs(array $args): void
    {
        // only for non-recurring jobs
        if ($this->isRecurring === 0) {
            // datetime-local (input 'Y-m-d\TH:i:s.uP', output: 'Y-m-d H:i:s')
            $this->start = isset($this->job->start) ?
                $this->job->start->setTimezone(Job::TIMEZONE) :
                $this->dateTimeService->convertFromUtcToLocal($args['start'], Job::TIMEZONE, false,
                    'Y-m-d\TH:i:s.uP');

            if (isset($args['end'])) {
                // input 'Y-m-d\TH:i:s.uP', output: 'Y-m-d H:i:s'
                $this->end = isset($this->job->end) ?
                    $this->job->end->setTimezone(Job::TIMEZONE) :
                    $this->dateTimeService->convertFromUtcToLocal($args['end'], Job::TIMEZONE, false,
                        'Y-m-d\TH:i:s.uP');

            } else {
                $this->end = $this->job->end->setTimezone(Job::TIMEZONE) ?? null;
            }
        }



        if ($this->dtstart === '') {
            /* Need to set dtstart for the modal for recurring jobs */
            $this->dtstart = isset($this->job->start) ?
                $this->job->start->setTimezone(Job::TIMEZONE) :
                $this->dateTimeService->convertFromUtcToLocal($args['start'], Job::TIMEZONE, false,
                    'Y-m-d\TH:i:s.uP');
        }

        $this->isModalOpen = true;

    }


    /**
     * @return void
     */
    private function setFrequencyNameAndInterval(): void
    {
        switch ($this->frequencyName) {
            case 'weekly':
                $this->frequencyName = 'weekly';
                $this->interval = 1;
                break;
            case '2-weekly':
                $this->frequencyName = 'weekly';
                $this->interval = 2;
                break;
            case '3-weekly':
                $this->frequencyName = 'weekly';
                $this->interval = 3;
                break;
            case '4-weekly':
                $this->frequencyName = 'weekly';
                $this->interval = 4;
                break;
            default:
                $this->interval = 1;
        }
    }


    /**
     * @return void
     */
    private function setFrequencyName(): void
    {
        if ($this->frequencyName === 'weekly') {
            if ($this->interval === 1) {
                $this->frequencyName = 'weekly';
            } else {
                if ($this->interval === 2) {
                    $this->frequencyName = '2-weekly';
                } else {
                    if ($this->interval === 3) {
                        $this->frequencyName = '3-weekly';
                    }
                }
            }
        } else {
            if ($this->frequencyName === 'monthly') {
                $this->frequencyName = 'monthly';
            } else {
                $this->frequencyName = 'weekly';
            }
        }
    }
}
