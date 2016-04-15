<?php
Route::group(['middleware' => 'web'], function () {
    Route::get('/', "indexController@index");

    Route::get('/hello', function () {
        $users = DB::table('users')->first();
        return 'Hello ' . $users->name;
    });

    Route::get('tv/{tv}', 'TvController@showTv');

    Route::auth();
    Route::get('getList', function () {
        Artisan::call('tv:getList');
    });

});


Route::auth();

Route::get('/home', 'HomeController@index');
