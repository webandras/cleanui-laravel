<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;

    /**
     * Code validity expiration in minutes
     */
    public const CODE_VALIDITY_EXPIRATION = 1;


    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'code',
    ];

}
