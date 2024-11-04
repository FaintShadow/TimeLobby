<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'description',
        'established_at',
    ];

    public function academicStaff(): hasMany
    {
        return $this->hasMany(User::class, 'institute_id')->where('role', 'like', 'institute-%');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'institute_id')->whereNull('role');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class, 'institute_id')->where('role', 'like', 'teacher');
    }

    public function years(): HasMany
    {
        return $this->hasMany(Year::class, 'institute_id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'institute_id');
    }

    public function courses(): hasMany
    {
        return $this->hasMany(Course::class, 'institute_id');
    }

}
