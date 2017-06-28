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

    // Sets the page number to 1 if a valid one is not provided
    if (is_null($page) || $page < 1 ) {
      $page = 1;
    }

    // Query the users table and eager load connections
    $users = User::with('connections')
                    ->select('id', 'firstname', 'lastname', 'favorite_color')
                    ->offset(($page - 1) * 25)
                    ->limit(25)
                    ->get();
    return $users;
  }

  // Queries users table for user with specified id and returns as JSON
  public function show($id) {
    $user = User::with('connections')
                    ->where('id','=',$id)
                    ->select('id', 'firstname', 'lastname', 'favorite_color');
    return $user->first();
  }
}
