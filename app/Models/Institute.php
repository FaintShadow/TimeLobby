<?php

namespace App\Models;

use Database\Factories\InstituteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Institute extends Model
{
    /** @use HasFactory<InstituteFactory> */
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'established_at',
    ];

    public function academicStaff(): HasMany
    {
        return $this->hasMany(User::class)->whereIn('role', [
            'institute-admin',
            'institute-manager'
        ]);
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class)->Where('role', 'like', 'student');
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'like', 'teacher');
    }

    public function years(): BelongsToMany
    {
        return $this->belongsToMany(Year::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class)->whereNull('main_group_id');
    }

    public function subgroups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)->whereNotNull('main_group_id');
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'established_at' => $this->established_at
        ];
    }


}
