<?php
Route::group(['middleware' => 'web'], function () {
    Route::get('/', "indexController@index");

    Route::get('/hello', function () {
        $users = DB::table('users')->first();
        return 'Hello ' . $users->name;
    });

    Route::get('tv/{tv}', 'TvController@showTv');
    Route::any('subscribe/{tv}', 'SubController@sub');
    Route::any('unsubscribe/{tv}', 'SubController@unSub');
    Route::any('login', 'SubController@login');
    Route::get('logout', 'SubController@logout');
    Route::get('getList', function () {
        Artisan::call('tv:getList');
    });

});

