<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;
    protected $fillable = [
        'name'
    ];

    protected function courses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }


}
