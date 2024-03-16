<?php

namespace App\Models\Clean;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    use HasFactory;


    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'code',
    ];

}
