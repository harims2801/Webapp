<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectIDs = DB::table('projects')->pluck('id');
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            \App\Models\Task::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'project_id' => $faker->randomElement($projectIDs),
                'status' => 'created',
            ]);
        }
    }
}
