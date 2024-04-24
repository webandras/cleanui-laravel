<?php

namespace App\Trait\Clean;

use App\Models\Clean\UserPreference;

use Illuminate\Database\Eloquent\Relations\HasOne;


trait HasPreferences {

    /**
     * @return HasOne
     */
    public function preferences(): HasOne    {
        return $this->hasOne(UserPreference::class);
    }
}

