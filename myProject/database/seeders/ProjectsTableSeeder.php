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
        // Let's truncate our existing records to start from scratch.
        Projects::truncate();

        $faker = \Faker\Factory::create();

        // And now, let's create a few Projects in our database:
        for ($i = 0; $i < 50; $i++) {
            Projects::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
            ]);
            }
    }
}
