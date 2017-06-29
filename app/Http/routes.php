<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/users/', 'UsersController@index');
Route::get('api/users/{user}', 'UsersController@show');
Route::get('api/users/{user_id}/{connection_id}', 'UsersController@deleteConnection');

Route::post('testdata', function (Request $request) {
  $userCount = (int)$request->query('userCount');
  try {
      DB::beginTransaction();
      Artisan::call('migrate:refresh');
      Artisan::call('db:reseed',['userCount' => $userCount]);
      DB::commit();
      return 'Database successfully reseeded';
  } catch (\PDOException $e) {
      DB::rollBack();
  }
});
