<?php

namespace App\Http\Controllers;

use App\User;

class UsersController extends Controller
{
    // Queries users table for all users and returns them as JSON
    public function index() {
      $users = User::all();
      return $users;
    }

    // Queries users table for user with specified id and returns as JSON
    public function show(User $user) {
      return $user;
    }
}
