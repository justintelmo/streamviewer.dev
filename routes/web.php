<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get( '/', 'Web\AppController@getApp' )
      ->middleware('auth');

Route::get('/login', 'Web\AppController@getLogin' )
      ->name('login')
      ->middleware('guest');

Route::get( '/login/{social}', 'Web\AuthenticationController@getSocialRedirect' )
      ->middleware('guest');

Route::get( '/login/{social}/callback', 'Web\AuthenticationController@getSocialCallback' )
      ->where('social', 'google');

Route::get( '/logout', 'Web\AuthenticationController@socialLogout' );

Route::group(['middleware' => 'web'], function() {
      Route::get( '/streams', 'Web\StreamsController@getStreams' );
      Route::get( '/callback', 'Web\StreamsController@authCallback' );
});