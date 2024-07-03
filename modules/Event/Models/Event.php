<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Mews\Purifier\Casts\CleanHtml;
use Modules\Clean\Casts\HtmlSpecialCharsCast;
use Modules\Clean\Casts\StripTagsCast;
use Modules\Event\Database\Factories\EventFactory;
use Modules\Event\Interfaces\Entities\EventInterface;

class Event extends Model implements EventInterface
{
    use HasFactory;

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
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            'posted' => __('Posted'),
            'cancelled' => __('Cancelled'),
        ];
    }


    /**
     * @return string
     */
    public static function getLocaleDateTimeFormat(): string {
        $locale = config('app.locale');

        return match ($locale) {
            'hu' => 'Y. M j. H:i',
            default => 'jS \o\f F Y H:i',
        };
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
