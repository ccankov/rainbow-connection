<?php

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
      DB::table('users')->insert([
          'firstname' => str_random(10),
          'lastname' => str_random(10),
          'favorite_color' => str_random(10),
          'email' => str_random(10).'@gmail.com',
          'password' => bcrypt('secret'),
      ]);

      DB::table('users')->insert([
          'firstname' => str_random(10),
          'lastname' => str_random(10),
          'favorite_color' => str_random(10),
          'email' => str_random(10).'@gmail.com',
          'password' => bcrypt('secret'),
      ]);

      DB::table('users')->insert([
          'firstname' => str_random(10),
          'lastname' => str_random(10),
          'favorite_color' => str_random(10),
          'email' => str_random(10).'@gmail.com',
          'password' => bcrypt('secret'),
      ]);
    }
}
