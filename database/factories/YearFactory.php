<?php

namespace Database\Factories;

use App\Models\Institute;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Year>
 */
class YearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
        ];
    }


    public function configure(): YearFactory|Factory
    {
        return $this->afterCreating(function (Year $year) {
            $year->institutes()->saveMany(Institute::all()->random(1, Institute::count()));
        });
    }


}
