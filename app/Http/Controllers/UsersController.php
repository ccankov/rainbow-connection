<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
  // Queries users table for all users and returns them as JSON
  public function index() {
    //$users = User::select('id', 'firstname', 'lastname', 'favorite_color')->get();

    $users = User::with('connections')
                    ->select('id', 'firstname', 'lastname', 'favorite_color')
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
