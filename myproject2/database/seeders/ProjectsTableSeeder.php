<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Project::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            \App\Models\Project::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
            ]);
        }
    }
}
