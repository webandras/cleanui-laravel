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

    public static function values(): array
    {
        return collect(self::cases())
            ->map(fn ($enum) => $enum->value)
            ->toArray();
    }
}
