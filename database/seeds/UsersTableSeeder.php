<?php

use Illuminate\Database\Seeder;

use App\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($userCount = null)
    {
      Eloquent::unguard();

      // Assigns a random userCount if a valid one is not provided
      if (is_null($userCount) || $userCount < 1 ) {
        $userCount = rand(1,200);
      }

      $users = [];
      $faker = Faker::create();

      // Iterate userCount times and create a random user each time
    	foreach (range(0, $userCount - 1) as $index) {
        array_push($users, [
          'firstname' => $faker->firstName,
          'lastname' => $faker->lastName,
          'favorite-color' => $faker->safeColorName
        ]);
      }

      // Insert users into database
      DB::table('users')->insert($users);

      // Tracks the number of connections of each user
      $connectionCounts = array_fill(0, $userCount, 0);
      $connections = [];

      $users = User::all();

      // Populates the random connections for each user, ensuring none exceed 50
      foreach ($users as $idx => $user) {
        $currentConnections = $connectionCounts[$idx];
        $targetConnections = rand(0, 50 - $currentConnections);

        while ($currentConnections < $targetConnections) {
          $randomConnection = rand(0, $userCount - 1);
          if ($connectionCounts[$randomConnection] < 50) {
            $user->addFriend($users[$randomConnection]);


            $connectionCounts[$idx]++;
            $connectionCounts[$randomConnection]++;
            $currentConnections = $connectionCounts[$idx];
          }
        }
      }

      // // Users the User factory to create $userCount random users
      // $users = factory(App\User::class, $userCount)->create();
    }
}
