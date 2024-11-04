<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = [
        'name',
        'academic-year',
        'maxCapacity',
        'minCapacity',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'like','student');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    protected function teachers(): HasMany
    {
        return $this->hasMany();
    }

}
