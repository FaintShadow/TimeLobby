<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Building extends SpecifiableModel
{
    protected $fillable = [
        'name'
    ];

    protected function classRooms(): hasMany
    {
        return $this->hasMany(Building::class, 'main-building');
    }

    protected function mainBuilding(): belongsTo
    {
        return $this->belongsTo(Building::class);
    }

    protected function specifics(): MorphMany
    {
        return $this->morphMany(Specific::class, 'specifiable');
    }


}
