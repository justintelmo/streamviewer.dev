<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1', 'middleware' => 'web'], function() {
    Route::get('/user', function( Request $request ){
      return $request->user();
    });

    Route::get('/authCallback', 'API\StreamsController@clientCallback');
    Route::get('/streams', 'API\StreamsController@getStreams');
    Route::get('/streams/{id}', 'API\StreamsController@getStream');
    Route::get('/streams', 'API\StreamsController@getStreams' );
    Route::post('/streams', 'API\StreamsController@updateStreams');
    Route::get('/messages/{id}', 'API\ChatMessageController@getMessages');
});
