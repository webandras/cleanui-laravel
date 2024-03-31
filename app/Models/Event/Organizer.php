<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organizer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'facebook_url',
    ];

    protected $dates = ['deleted_at'];


    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
