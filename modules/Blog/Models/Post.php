<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Mews\Purifier\Casts\CleanHtml;
use Modules\Blog\Database\Factories\PostFactory;
use Modules\Clean\Casts\HtmlSpecialCharsCast;

class Post extends Model
{
    use HasFactory;

    public const RECORDS_PER_PAGE = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'status',
        'slug',
        'content',
        'excerpt',
        'is_highlighted',
        'cover_image_url',
        'author_id'
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'title' => HtmlSpecialCharsCast::class,
        'content' => CleanHtml::class,
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }


    /**
     * Categories belonging to posts
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'posts_categories');
    }


    /**
     * Tags belonging to posts
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'posts_tags');
    }


    /**
     * Gets the slug from the post title
     *
     * @param  array  $data
     * @return array
     */
    public static function getSlugFromTitle(array $data): array
    {
        if ( ! isset($data['slug']) || $data['slug'] === '') {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeNewestPosts($query): mixed
    {
        return $query->where('status', '=', 'published')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get(['title', 'cover_image_url', 'slug', 'created_at']);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeHighlightedPosts($query): mixed
    {
        return $query->where('status', '=', 'published')
            ->where('is_highlighted', '=', 1)
            ->orderByDesc('created_at')
            ->get();
    }

}
