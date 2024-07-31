<?php

namespace Modules\Blog\Enum;

use App\Traits\WithOptions;

enum PostStatus: string
{
    use WithOptions;

    case DRAFT = 'draft';
    case UNDER_REVIEW = 'under-review';
    case PUBLISHED = 'published';

    /**
     * Get post statuses with translatable labels
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => __('Draft'),
            self::UNDER_REVIEW => __('Under review'),
            self::PUBLISHED => __('Published'),
        };
    }


    /**
     * @return string
     */
    public function color(): string {

        return match ($this) {
            self::DRAFT => 'red',
            self::UNDER_REVIEW => 'orange',
            self::PUBLISHED => 'green',
        };
    }


    /**
     * Get post statuses with colors
     *
     * @return array
     */
    public static function colors(): array
    {
        $colors[self::DRAFT->value] = 'red';
        $colors[self::UNDER_REVIEW->value] = 'orange';
        $colors[self::PUBLISHED->value] = 'green';

        return $colors;
    }

}
