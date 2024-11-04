<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Course extends SpecifiableModel
{
    protected $fillable = [
        'name'
    ];

    protected function teachers(): hasMany
    {
        return $this->hasMany(User::class)->where('role', 'like', 'teacher');
    }

    protected function students(): hasMany
    {
        return $this->hasMany(User::class)->where('role', 'like', 'student');
    }

    protected function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected function specifics(): MorphMany
    {
        return $this->morphMany(Specific::class, 'specificable');
    }
}
