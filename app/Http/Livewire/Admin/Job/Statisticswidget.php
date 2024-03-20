<?php

namespace App\Http\Livewire\Admin\Job;

use App\Models\Job\Client;
use App\Models\Job\Job;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Statisticswidget extends Component
{
    use WithPagination;

    /**
     * Paginated Collection of jobs (events)
     * @var
     */
    protected $jobs;

    /**
     * The client you want to generate the statistics for
     *
     * @var int
     */
    public int $clientId;

    public Collection $clients;

    // client name and id for select field
    public array $clientsData;

    // for filtering by date interval
    public string $startDate;
    public string $endDate;


    protected array $rules = [
        'clientId' => ['required', 'int', 'max:255'],
        'startDate' => ['nullable', 'date'],
        'endDate' => ['nullable', 'date'],
    ];


    /**
     * @throws Exception
     */
    public function mount(): void
    {
        $this->jobs = null;
        $this->clientId = 0;

        $firstDayOfTheMonth = new DateTime('first day of this month', new DateTimeZone('Europe/Budapest'));
        $lastDayOfTheMonth = new DateTime('last day of this month', new DateTimeZone('Europe/Budapest'));

        $this->startDate = $firstDayOfTheMonth->format('Y-m-d');
        $this->endDate = $lastDayOfTheMonth->format('Y-m-d');

        $this->clients = Client::all();
        $this->clientsData[__('All')] = 0;

        foreach ($this->clients as $client) {
            $this->clientsData[$client->name] = $client->id;
        }
    }


    /**
     * @throws Exception
     */
    public function render()
    {
        $this->getJobList();

        return view('admin.livewire.job.statistics_widget')->with([
            'jobs' => $this->jobs
        ]);
    }


    /**
     * @throws Exception
     */
    public function getJobList(): void
    {
        // validate user input
        $this->validate();

        $tz = new DateTimeZone('Europe/Budapest');
        $startDate = new DateTime($this->startDate, $tz);
        $endDate = new DateTime($this->endDate, $tz);
        $interval = $startDate->diff($endDate);
        $weeks = (int) floor($interval->days / 7);


        $result = DB::table('jobs')
            ->selectRaw(
                "clients.name,
                        jobs.status,
                        jobs.is_recurring,
                        CASE
                            WHEN (jobs.is_recurring = 0) THEN
                                TIME_FORMAT(ABS(TIMEDIFF(jobs.start, jobs.end)),'%H:%i')
                            WHEN (jobs.is_recurring = 1) THEN
                                TIME_FORMAT(jobs.duration,'%H:%i')
                        END AS durationCalc,

                        CASE
                            WHEN (jobs.is_recurring = 0) THEN
                                TIME_TO_SEC(TIMEDIFF(jobs.end, jobs.start)) / 3600
                            WHEN (jobs.is_recurring = 1) THEN
                                TIME_TO_SEC(jobs.duration) / 3600 * FLOOR( $weeks / JSON_EXTRACT(`rrule` , '$.interval') )
                        END AS hours,
                        jobs.start,
                        jobs.end,
                        jobs.rrule"
            )
            ->join('clients', 'jobs.client_id', '=', 'clients.id');

        $result = $this->addWhereConditionsToQueries($result);
        $result = $result
            ->orderByDesc('clients.name')
            ->groupBy('clients.name',
                'jobs.status',
                'jobs.is_recurring',
                'durationCalc',
                'hours',
                'jobs.rrule',
                'jobs.start',
                'jobs.end'
            )
            ->paginate(Job::RECORDS_PER_PAGE);

        $this->jobs = $result;
    }


    /**
     * @return void
     * @throws Exception
     */
    public function getResults(): void
    {
        $this->getJobList();
        $this->resetPage();
    }


    /**
     * @param $query
     *
     * @return mixed
     */
    private function addWhereConditionsToQueries($query): mixed
    {

        if ($this->clientId === 0) {
            $query = $query
                ->whereRaw("jobs.start > ? AND jobs.start < ?", [$this->startDate, $this->endDate])
                ->orWhereRaw("DATE(JSON_UNQUOTE(JSON_EXTRACT(jobs.rrule , '$.dtstart'))) > ?", [$this->startDate]);
        } else {
            $query = $query
                ->whereRaw("jobs.start > ? AND jobs.start < ? AND jobs.client_id = ?",
                    [$this->startDate, $this->endDate, $this->clientId])
                ->orWhereRaw("DATE(JSON_UNQUOTE(JSON_EXTRACT(jobs.rrule , '$.dtstart'))) > ? AND jobs.client_id = ? ",
                    [$this->startDate, $this->clientId]);
        }

        return $query;
    }
}
