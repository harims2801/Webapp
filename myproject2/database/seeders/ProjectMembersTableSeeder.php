<?php

namespace Database\Seeders;
use DB;
use Illuminate\Database\Seeder;

class ProjectMembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectIDs = DB::table('projects')->pluck('id');
        $userIDs = DB::table('users')->pluck('id');
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 4; $i++) {
            \App\Models\ProjectMember::create([
                'user_id' => $faker->randomElement($userIDs),
                'project_id' => $faker->randomElement($projectIDs),
            ]);
        }
    }
}

