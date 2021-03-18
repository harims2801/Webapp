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
        $project_Descriptions = array(
            "Avaya Phone system",
            "Manage Engine Deployment",
            "CI/CD",
            "Fishbowl",
            "active Directory Automation",
            "cyber security",
            "HR Automation",
            "IT ServiceDesk",
            "Facilities Management",
            "AD Audit",
            "ServiceNow Rollout",
            "FileShare Cleanup"

        );


        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 4; $i++) {
            \App\Models\Project::create([
                'name' => "MCIT Project Title".($i+1),//$faker->sentence,
                'description' => $faker->randomElement($project_Descriptions),//$faker->paragraph,
                'start_date' => Carbon::createFromDate(2021,01,$i+1),
                'end_date' => Carbon::createFromDate(2021,01,$i+1)->addDays($i),
            ]);
        }
    }
}
