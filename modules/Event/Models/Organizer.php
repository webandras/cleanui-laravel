<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Event\Database\Factories\OrganizerFactory;

class Organizer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const RECORDS_PER_PAGE = 10;

    protected $fillable = [
        'name',
        'slug',
        'facebook_url',
    ];

    protected $dates = ['deleted_at'];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return OrganizerFactory::new();
    }


    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
