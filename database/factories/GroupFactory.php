<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(15),
            'academic_year' => $this->faker->year(),
        ];
    }

    public function configure(): GroupFactory|Factory
    {
        return $this->afterMaking(function (Group $group): void {
            $group->year()->associate(Year::all()->random(1)->first());
        });
    }
}
