<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $task_Descriptions = array(
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

        $states = array('assigned','pending');
        $projectIDs = DB::table('projects')->pluck('id');
        $userIDs = DB::table('users')->pluck('id');
        $faker = \Faker\Factory::create();
        $project_id = 1;
        $task_id = 1;
        for ($i = 0; $i < 15; $i++) {

            \App\Models\Task::create([
                'title' => "MCIT Task ".$task_id." in project ".$project_id,
                'description' => $faker->paragraph,
                'project_id' => $project_id,
                'AssignedTo' => $faker->randomElement($userIDs),
                'status' => $faker->randomElement($states),
                'dead_line' => Carbon::createFromDate(2021,01,$i+1),
            ]);
            if ($i%2 == 0) {
                $project_id = $project_id +1;
                $task_id = 1;
            }else{
                $task_id = 2;
            }
        }
    }
}
