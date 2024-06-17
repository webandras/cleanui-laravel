<?php

namespace Modules\Event\Models;

use Database\Factories\Event\EventDetailFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'facebook_url',
        'cover_image_url',
        'tickets_url',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return EventDetailFactory::new();
    }


    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
