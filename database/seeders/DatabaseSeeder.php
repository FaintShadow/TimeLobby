<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(15)->create();
        Institute::factory(125)->create();

        /*
        User::factory()->create([

            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
    }
}
