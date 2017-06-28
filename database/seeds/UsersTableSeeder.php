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
      $users = factory(App\User::class, 10)->create();

      $users[0]->addFriend($users[1]);
      $users[0]->addFriend($users[2]);
      $users[2]->addFriend($users[8]);
    }
}
