<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$d = $faker->date;
        //$d = Carbon::createFromDate(2021,01,01)->toDateString();
        //\App\Models\Project::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            \App\Models\Project::create([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'start_date' => Carbon::createFromDate(2021,01,$i+1),
                'end_date' => Carbon::createFromDate(2021,01,$i+1)->addDays($i),
            ]);
        }
    }
}
