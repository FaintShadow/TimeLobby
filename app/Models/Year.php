<?php

namespace App\Models;

use Database\Factories\YearFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Year extends Model
{
    /** @use HasFactory<YearFactory> */
    use HasFactory, Searchable;

    public $timestamps = false;
    protected $fillable = [
        'name'
    ];

    public function institutes(): BelongsToMany
    {
        return $this->BelongsToMany(Institute::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class)->whereNull('main_group_id');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name
        ];
    }
}
