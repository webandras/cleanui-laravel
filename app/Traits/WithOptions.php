<?php

namespace App\Traits;

trait WithOptions
{
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($enum) =>
            [
                $enum->value => $enum->label()
            ]
            )->toArray();
    }
}
