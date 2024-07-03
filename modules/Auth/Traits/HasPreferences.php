<?php

namespace Modules\Auth\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Models\UserPreference;


trait HasPreferences {

    /**
     * @return HasOne
     */
    public function preferences(): HasOne    {
        return $this->hasOne(UserPreference::class);
    }
}

