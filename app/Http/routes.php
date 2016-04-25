<?php
Route::group(['middleware' => 'web'], function () {
    Route::get('/', "indexController@index");

    Route::any('subscribe/{tv}', 'SubController@sub');
    Route::any('unsubscribe/{tv}', 'SubController@unSub');
    Route::any('login', 'SubController@login');
    Route::get('logout', 'SubController@logout');

    Route::get('tvDetail/{id}', 'IndexController@tvDetail');
//    Route::get('cmd/queue/{name}', function ($name) {
//        Artisan::call('queue:work', [
//            '--queue' => $name
//        ]);
//    });
//    Route::get('cmd/getList', function () {
//        Artisan::call('tv:getList');
//    });
});

