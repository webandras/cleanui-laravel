<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Blog\Database\Factories\TagFactory;
use Modules\Clean\Casts\HtmlSpecialCharsCast;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const RECORDS_PER_PAGE = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'cover_image_url',
        'category_id'
    ];


    protected array $dates = ['deleted_at'];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => HtmlSpecialCharsCast::class,
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TagFactory::new();
    }


    /**
     * Posts belonging to tags
     *
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'posts_tags');
    }


    public function scopeTrashedTags($query) {
        return $query->onlyTrashed();
    }


    public function scopeAllTagsWithTrashed($query) {
        return $query->withTrashed();
    }
}
