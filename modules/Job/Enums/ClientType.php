<?php

namespace Modules\Job\Enums;

use App\Traits\WithOptions;

enum ClientType: string
{
    use WithOptions;

    case COMPANY = 'company';
    case PRIVATE_PERSON = 'private person';

    public function label(): string
    {
        return match ($this) {
            self::COMPANY => __('Company'),
            self::PRIVATE_PERSON => __('Private Person'),

        };
    }
}
