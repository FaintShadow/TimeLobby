<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

class Course extends Model
{
    use Searchable;
    protected $fillable = [
        'name'
    ];

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'like', 'teacher');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class)->Where('role', 'like', 'student');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }
}
