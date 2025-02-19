<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Building extends Model
{
    use Searchable;

    public $timestamps = false;
    public static $classroomMinCap = 15;
    public static $buildingMinCap = 2;

    protected $fillable = [
        'name',
        'building_id',
        'institute_id',
        'maxCapacity'
    ];

    public function classes(): hasMany
    {
        return $this->hasMany(Building::class);
    }

    public function building(): belongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function institute(): belongsTo
    {
        return $this->belongsTo(Institute::class);
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
        ];
    }


}
