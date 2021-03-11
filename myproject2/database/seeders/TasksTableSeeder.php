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
        $states = array('Created','Assigned','Pending','Resolved');
        $projectIDs = DB::table('projects')->pluck('id');
        $userIDs = DB::table('users')->pluck('id');
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            \App\Models\Task::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'project_id' => $faker->randomElement($projectIDs),
                'AssignedTo' => $faker->randomElement($userIDs),
                'status' => $faker->randomElement($states),
                'dead_line' => Carbon::createFromDate(2021,01,$i+1),
            ]);
        }
    }
}
