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
        $role = ['member','admin'];
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 15; $i++) {
            // if ($i%2 == 0) {
            //     $role = 'admin';
            // }else{
            //     $role = 'member';
            // }
            \App\Models\ProjectMember::create([
                'user_id' => $faker->randomElement($userIDs),
                'project_id' => $faker->randomElement($projectIDs),
                'project_role' => $faker->randomElement($role)
            ]);
        }
    }
}

