<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Specific extends Model
{
    protected function specifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
