<?php

namespace Modules\Event\Enum;

use App\Traits\WithOptions;

enum EventStatus: string
{
    use WithOptions;

    case POSTED = 'posted';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::POSTED => __('Posted'),
            self::CANCELLED => __('Cancelled'),
        };
    }
}
