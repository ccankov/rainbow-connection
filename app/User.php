<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    /**
      * The other users who are connected to the user.
      */
    public function connections()
    {
      return $this->belongsToMany('App\User', 'connections', 'user_id', 'connection_id')->select('id', 'firstname', 'lastname', 'favorite-color');
    }

    /**
      * Create a connection between this user and the specified user.
      */
    public function addFriend(User $user)
    {
      try {
          DB::beginTransaction();
          $this->connections()->attach($user->id);
          $user->connections()->attach($this->id);
          DB::commit();
      } catch (\PDOException $e) {
          DB::rollBack();
      }
    }

    /**
      * Delete the connection between this user and the specified user.
      */
    public function removeFriend(User $user)
    {
      try {
          DB::beginTransaction();
          $this->connections()->detach($user->id);
          $user->connections()->detach($this->id);
          DB::commit();
      } catch (\PDOException $e) {
          DB::rollBack();
      }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
