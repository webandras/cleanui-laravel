<?php

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Clean\Casts\HtmlSpecialCharsCast;
use Modules\Clean\Traits\DateTimeConverter;

class Job extends Model
{
    use HasFactory;
    use DateTimeConverter;

    // no need for timestamps
    public $timestamps = false;

    protected $primaryKey = "id";

    public const RECORDS_PER_PAGE = 10;
    public const TIMEZONE = 'Europe/Budapest';

    // the primary key is non-incrementing and an uuid string
    // if we want to use uuid as primary key
//    public $incrementing = false;
//    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'client_id',
        'title',
        'start',
        'end',
        'rrule',
        'is_recurring',
        'address',
        'description',
        'status',
        'backgroundColor',
        'duration',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => HtmlSpecialCharsCast::class,
        'start' => 'datetime', // ISO8601 (fullcalendar needs this format, mysql does not support it)
        'end' => 'datetime', // ISO8601
        'rrule' => 'array',
        'address' => HtmlSpecialCharsCast::class,
        'description' => HtmlSpecialCharsCast::class,
        'status' => HtmlSpecialCharsCast::class,
        'backgroundColor' => HtmlSpecialCharsCast::class,
        'duration' => HtmlSpecialCharsCast::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'workers_jobs', 'job_id', 'worker_id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

}
