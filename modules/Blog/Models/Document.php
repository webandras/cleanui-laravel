<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Blog\Database\Factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
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
     * Document statuses (enum in the table)
     */
    public const STATUSES = [
        'draft',
        'under-review',
        'published',
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
     * Get document statuses with translatable labels
     * @return array
     */
    public static function getDocumentStatuses(): array
    {
        // Multi-language texts for the statuses
        $statusNames = [
            __('Draft'),
            __('Under review'),
            __('Published'),
        ];

        $documentStatuses = [];
        for ($i = 0; $i < 3; $i++) {
            $documentStatuses[Document::STATUSES[$i]] = $statusNames[$i];
        }

        return $documentStatuses;
    }


    /**
     * Get document statuses with translatable labels
     * @return array
     */
    public static function getDocumentStatusColors(): array
    {
        // Multi-language texts for the statuses
        $colors = [
            'red',
            'orange',
            'green',
        ];

        $documentStatusColors = [];
        for ($i = 0; $i < 3; $i++) {
            $documentStatusColors[Document::STATUSES[$i]] = $colors[$i];
        }

        return $documentStatusColors;
    }


    /**
     * Gets the slug from the document title
     *
     * @param array $data
     * @return array
     */
    public static function getSlugFromTitle(array $data): array
    {
        if (!isset($data['slug']) || $data['slug'] === '') {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }
}
