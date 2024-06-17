<?php

namespace Modules\Event\Models;

use Database\Factories\Event\LocationFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'address',
        'city',
        'slug',
        'latitude',
        'longitude',
    ];

    protected $dates = ['deleted_at'];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return LocationFactory::new();
    }


    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

}
