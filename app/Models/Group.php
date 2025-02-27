<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Group extends Model
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'academic_year',
        'maxCapacity',
        'minCapacity',
        'group_id',
        'year_id',
    ];

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class);
    }

    public function subgroups(): HasMany
    {
        return $this->hasMany(Group::class, 'main_group_id');
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institute::class);
    }

    public function courses(): hasMany
    {
        return $this->belongsToMany(Course::class);
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
            'academic_year' => $this->academic_year
        ];
    }


}
