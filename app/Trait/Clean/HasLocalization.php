<?php

namespace App\Trait\Clean;

use Illuminate\Support\Facades\App;

trait HasLocalization
{

    /**
     * @return string
     */
    public static function getLocaleDateTimeFormat(): string
    {
        $locale = App::getLocale();

        return match ($locale) {
            'hu' => 'Y. M j. H:i',
            default => 'jS \o\f F Y H:i',
        };
    }
}
