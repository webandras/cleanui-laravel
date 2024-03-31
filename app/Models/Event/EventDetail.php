<?php

namespace App\Models\Event;

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
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
