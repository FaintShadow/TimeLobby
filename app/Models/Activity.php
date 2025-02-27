<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Activity extends Model
{
    use Searchable;
    protected $fillable = [
        'name'
    ];

    protected function mainActivity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    protected function activities(): hasMany
    {
        return $this->hasMany(Activity::class, 'main-activity-id');
    }
}
