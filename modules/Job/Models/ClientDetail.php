<?php

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Job\Database\Factories\ClientDetailFactory;

class ClientDetail extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'contact_person',
        'phone_number',
        'email',
        'tax_number',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return ClientDetailFactory::new();
    }


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id', 'client_id');
    }
}
