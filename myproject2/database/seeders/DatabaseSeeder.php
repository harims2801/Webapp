<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ProjectsTableSeeder::class,
            TasksTableSeeder::class,
            ProjectMembersTableSeeder::class]
    );
        //$this->call(ProjectsTableSeeder::class);

    }
}
