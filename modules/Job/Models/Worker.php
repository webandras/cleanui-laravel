<?php

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Job\Database\Factories\WorkerFactory;

class Worker extends Model
{
    use HasFactory;

    public const RECORDS_PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'bank_account_number',
        'bank_account_name',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return WorkerFactory::new();
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopePaginatedWorkers($query)
    {
        return $query->orderBy('created_at', 'DESC')
            ->paginate(Worker::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @return BelongsToMany
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'workers_jobs');
    }

}
