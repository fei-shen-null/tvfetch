<?php

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

Route::get('/hello', function () {
    $users = DB::table('users')->first();
    return 'Hello ' . $users->name;
});

Route::get('tv/{tv}', 'TvController@showTv');

Route::auth();
Route::get('getList', function () {
    Artisan::call('tv:getList');
});