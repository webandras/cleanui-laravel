<?php

namespace Modules\Clean\Models;

use App\Casts\HtmlSpecialCharsCast;
use Database\Factories\Clean\PostFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Mews\Purifier\Casts\CleanHtml;
use Modules\Clean\Interfaces\Entities\PostInterface;

class Post extends Model implements  PostInterface
{
    use HasFactory;


    /**
     * Post statuses (enum in the table)
     */
    public const STATUSES = [
        'draft',
        'under-review',
        'published',
    ];


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
     * Get post statuses with translatable labels
     * @return array
     */
    public static function getPostStatuses(): array {
        // Multi-language texts for the statuses
        $statusNames = [
            __('Draft'),
            __('Under review'),
            __('Published'),
        ];

        $postStatuses = [];
        for($i = 0; $i < 3; $i++) {
            $postStatuses[Post::STATUSES[$i]] = $statusNames[$i];
        }

        return $postStatuses;
    }


    /**
     * Get post statuses with translatable labels
     * @return array
     */
    public static function getPostStatusColors(): array {
        // Multi-language texts for the statuses
        $colors = [
            'red',
            'orange',
            'green',
        ];

        $postStatusColors = [];
        for($i = 0; $i < 3; $i++) {
            $postStatusColors[Post::STATUSES[$i]] = $colors[$i];
        }

        return $postStatusColors;
    }


    /**
     * Gets the slug from the post title
     *
     * @param  array  $data
     * @return array
     */
    public static function getSlugFromTitle(array $data): array
    {
        if (!isset($data['slug']) || $data['slug'] === '') {
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
