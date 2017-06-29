<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
  // Queries users table for all users and returns them as JSON, up to 25
  public function index(Request $request) {
    // Gets the page number from the query string
    $page = $request->query('page');
    $id = $request->query('id');

    // Sets the page number to 1 if a valid one is not provided
    if (is_null($page) || $page < 1 ) {
      $page = 1;
    }

    if (is_null($id)) {
      // Query the users table and eager load connections
      $users = User::with('connections')
                      ->select('id', 'firstname', 'lastname', 'favorite-color')
                      ->offset(($page - 1) * 25)
                      ->limit(25)
                      ->get();
      $jsonUsers = array_map(function ($user) {
        return [ "id" => $user["id"], "type" => "user", "attributes" => collect($user) ];
      }, $users->toArray());
      return [
        "data" => $jsonUsers,
        "meta" => ["total_pages" => ceil(User::count() / 25)]
      ];
    } else {
      // Query and return the particular user
      $users = User::with('connections')
                      ->where('id','=',$id)
                      ->select('id', 'firstname', 'lastname', 'favorite-color');

      $user = $users->first();
      return [
        "data" => [ "id" => $user->id, "type" => "user", "attributes" => $user ]
      ];
    }
  }

  // Queries users table for user with specified id and returns as JSON
  public function show($id) {
    $user = User::with('connections')
                    ->where('id','=',$id)
                    ->select('id', 'firstname', 'lastname', 'favorite-color');
    return $user->first();
  }

  // Deletes the connection between the users with specified ids
  public function deleteConnection($user_id, $connection_id) {
    $user = User::find($user_id);
    $connection = User::find($connection_id);
    $user->removeFriend($connection);
    $queryUser = User::with('connections')
                    ->where('id','=',$user_id)
                    ->select('id', 'firstname', 'lastname', 'favorite-color');
    return $queryUser->first();
  }
}
