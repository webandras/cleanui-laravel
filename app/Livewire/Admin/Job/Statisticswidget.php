<?php

namespace App\Livewire\Admin\Job;

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


    /**
     * The data to pass to the Google Chart library to render
     *
     */
    public Collection|array $chartData;


    // for filtering by date interval
    public string $startDate;
    public string $endDate;


    /* Chart option properties */
    public string $chartTitle;
    public string $chartId;
    public string $chartAreaWidth;
    public string $chartColor;
    public string $chartXAxisTitle;
    public string $chartVAxisTitle;

    public $totalJobs;


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
        $this->chartData = [];
        $this->totalJobs = null;

        $firstDayOfTheMonth = new DateTime('first day of this month', new DateTimeZone('Europe/Budapest'));
        $lastDayOfTheMonth = new DateTime('last day of this month', new DateTimeZone('Europe/Budapest'));

        $this->startDate = $firstDayOfTheMonth->format('Y-m-d');
        $this->endDate = $lastDayOfTheMonth->format('Y-m-d');

        $this->clients = Client::all();
        $this->clientsData[__('All')] = 0;

        foreach ($this->clients as $client) {
            $this->clientsData[$client->name] = $client->id;
        }

        $this->chartTitle = __('Hours of jobs done for clients');
        $this->chartId = 'chart_div';
        $this->chartAreaWidth = '65%';
        $this->chartColor = '#13B623';
        $this->chartXAxisTitle = __('Hours of work');
        $this->chartVAxisTitle = __('Client name');
    }


    /**
     * @throws Exception
     */
    public function render()
    {
        $this->queryDataForChart();
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
        $this->queryDataForChart();
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


    /**
     * @throws Exception
     */
    public function queryDataForChart(): void
    {
        // validate user input
        $this->validate();

        $tz = new DateTimeZone('Europe/Budapest');
        $startDate = new DateTime($this->startDate, $tz);
        $endDate = new DateTime($this->endDate, $tz);
        $interval = $startDate->diff($endDate);

        $statistics = DB::table('jobs')
            ->selectRaw(
                "clients.name,
                        CAST( 7 * JSON_UNQUOTE( JSON_EXTRACT( jobs.rrule, '$.interval' ) ) AS UNSIGNED ) AS per_week,
                            ( CASE
                                WHEN ( jobs.is_recurring = 0 ) THEN
                                    SUM( TIME_TO_SEC( TIMEDIFF( jobs.end, jobs.start ) ) / 3600 )
                                WHEN ( jobs.is_recurring = 1 ) THEN
                                   SUM( TIME_TO_SEC( jobs.duration ) / 3600 * (
                                        WITH RECURSIVE DateRange AS (
                                            SELECT ? AS StartDate
                                            UNION ALL
                                            SELECT DATE_ADD( StartDate, INTERVAL per_week DAY )
                                            FROM DateRange
                                            WHERE StartDate < DATE_ADD( ?, INTERVAL -per_week DAY )
                                    ) SELECT COUNT( StartDate ) FROM DateRange ) )
                            END ) AS hours", [$this->startDate, $this->endDate]
            )
            ->join('clients', 'jobs.client_id', '=', 'clients.id');

        $statistics = $this->addWhereConditionsToQueries($statistics);
        $statistics = $statistics
            ->groupBy('clients.name', 'jobs.is_recurring', 'jobs.rrule')
            ->get();

        $this->chartData = $statistics;
    }
}
