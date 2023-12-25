<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use App\Interface\Entities\TagInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model implements TagInterface
{
    use HasFactory;
    use SoftDeletes;

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

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => HtmlSpecialCharsCast::class,
    ];


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
