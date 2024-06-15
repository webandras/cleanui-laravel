<?php

namespace App\Trait\Clean;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Clean\Models\UserPreference;


trait HasPreferences {

    /**
     * @return HasOne
     */
    public function preferences(): HasOne    {
        return $this->hasOne(UserPreference::class);
    }
}

