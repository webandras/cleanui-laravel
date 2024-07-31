<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Modules\Blog\Database\Factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;

    public const RECORDS_PER_PAGE = 6;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'order',
    ];


    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return DocumentFactory::new();
    }


    /**
     * Gets the slug from the document title
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
     * @return LengthAwarePaginator
     */
    public function scopePaginatedDocuments($query): LengthAwarePaginator
    {
        return $query->with('documents')
            ->orderBy('created_at', 'DESC')
            ->paginate(Document::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @param $query
     * @return LengthAwarePaginator
     */
    public function scopePaginatedPublishedDocuments($query): LengthAwarePaginator
    {
        return $query->where('status', '=', 'published')
            ->with('documents')
            ->orderByDesc('created_at')
            ->paginate(Document::RECORDS_PER_PAGE);
    }


    /**
     * @param $query
     * @return Collection
     */
    public function scopePublishedDocuments($query): Collection
    {
        return $query->where('status', '=', 'published')
            ->orderBy('order', 'asc')
            ->get();
    }
}
