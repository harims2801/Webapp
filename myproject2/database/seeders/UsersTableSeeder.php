<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::truncate();
        $faker = \Faker\Factory::create();
        $password = Hash::make('test');
        $role = ['manager','admin','user'];
         //\App\Models\User::factory(10)->create();

          \App\Models\User::create([
             'name' => 'Administrator',
             'email' => 'admin@test.com',
             'password' => $password,
         ]);

        for ($i = 0; $i < 10; $i++) {
            \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $password,
                'user_role' => $faker->randomElement($role)
            ]);
        }
    }
}
