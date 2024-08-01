<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Pagination\LengthAwarePaginator;
use Mews\Purifier\Casts\CleanHtml;
use Modules\Clean\Casts\HtmlSpecialCharsCast;
use Modules\Clean\Casts\StripTagsCast;
use Modules\Event\Database\Factories\EventFactory;

class Event extends Model
{
    use HasFactory;

    public const POST_PER_PAGE = 8;

    // no need for timestamps
    public $timestamps = false;


    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'event_detail_id',
        'title',
        'slug',
        'description',
        'start',
        'end',
        'timezone',
        'backgroundColor',
        'backgroundColorDark',
        'organizer_id',
        'location_id',
        'allDay',
        'status'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'title' => StripTagsCast::class,
        'slug' => HtmlSpecialCharsCast::class,
        'description' => CleanHtml::class,
        'start' => 'datetime', // ISO8601 (fullcalendar needs this format, mysql does not support it)
        'end' => 'datetime', // ISO8601
        'timezone' => StripTagsCast::class,
        'backgroundColor' => StripTagsCast::class,
        'backgroundColorDark' => StripTagsCast::class,
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return EventFactory::new();
    }


    /**
     * @return string
     */
    public static function getLocaleDateTimeFormat(): string
    {
        $locale = config('app.locale');

        return match ($locale) {
            'hu' => 'Y. M j. H:i',
            default => 'jS \o\f F Y H:i',
        };
    }

    /**
     * @param $query
     * @param  string  $dateString
     * @param  string  $city
     * @param  int  $organizerId
     * @param  string  $searchTerm
     * @return LengthAwarePaginator
     */
    public function scopeFilter(
        $query,
        string $dateString,
        string $city,
        int $organizerId,
        string $searchTerm
    ): LengthAwarePaginator {
        $query->with('event_detail')
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->whereDate('start', '>', $dateString);

        if ($city !== '') {
            $query->whereHas('location', function ($q) use ($city) {
                $q->where('city', '=', $city)->withTrashed();
            });
        }

        if ($organizerId > 0) {
            $query->whereHas('organizer', function ($q) use ($organizerId) {
                $q->where('id', '=', $organizerId)->withTrashed();
            });
        }

        if ($searchTerm !== '') {
            $lowercase = '\'"'.mb_strtolower($searchTerm).'"\'';
            $uppercase = '\'"'.mb_strtolower($searchTerm).'"\'';
            $query->whereRaw("MATCH (title, description) AGAINST (? IN BOOLEAN MODE)", [$lowercase], 'and');
            $query->whereRaw("MATCH (title, description) AGAINST (? IN BOOLEAN MODE)", [$uppercase], 'and');
        }

        return $query->orderBy('start', 'asc')
            ->paginate(Event::POST_PER_PAGE);
    }


    /**
     * @param $query
     * @param  string  $dateString
     * @return LengthAwarePaginator
     */
    public function scopeNewerThanPaginated($query, string $dateString): LengthAwarePaginator
    {
        return $query->whereDate('start', '>', $dateString)
            ->with(['event_detail'])
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderBy('start', 'asc')
            ->paginate(Event::POST_PER_PAGE);
    }


    /**
     * @param $query
     * @param  string  $dateString
     * @return Collection
     */
    public function scopeNewerThan($query, $dateString): Collection
    {
        return $query->whereDate('start', '>', $dateString)
            ->with(['event_detail'])
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->get();
    }


    /**
     * @param $query
     * @param  int  $eventId
     * @return Event
     */
    public function scopeGetById($query, int $eventId): Event
    {
        return Event::where('id', '=', $eventId)
            ->with('event_detail')
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->firstOrFail();
    }


    /**
     * @param $query
     * @param  string  $slug
     * @return Event
     */
    public function scopeGetBySlug($query, string $slug): Event
    {
        return Event::where('slug', '=', strip_tags($slug))
            ->with('event_detail')
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->firstOrFail();
    }


    /**
     * @return HasOne
     */
    public function event_detail(): HasOne
    {
        return $this->hasOne(EventDetail::class);
    }


    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }


    /**
     * @return BelongsTo
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class, 'organizer_id', 'id');
    }

}
