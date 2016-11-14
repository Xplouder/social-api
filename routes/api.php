<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(array('prefix' => 'v1'), function()
{

    Route::get('/', function () {
        return response()->json(['message' => 'Thing Pink\'s Challenge API ', 'status' => 'Connected']);
    });

    // Feed
    Route::get('feed', 'UsersController@feed')->name('users.feed');

    // Auth
    Route::post('auth/login', 'AuthController@authenticate')->name('auth.login');
    Route::get('auth/{provider}', 'SocialAuthController@redirect')->name('auth.social.redirect');
    Route::get('auth/{provider}/callback', 'SocialAuthController@callback')->name('auth.social.callback');

    // Users
    Route::get('users/{id}', 'UsersController@show')->name('users.show');
    Route::post('users', 'UsersController@store')->name('users.store');

    // Posts
    Route::post('posts', 'PostsController@store')->name('posts.store');
    Route::put('posts/{post}', 'PostsController@update')->name('posts.update');
    Route::delete('posts/{post}', 'PostsController@destroy')->name('posts.destroy');

    // Other
    Route::get('images/{filename}', 'PostsController@getBodyImage')->name('images.show');
    Route::post('friends', 'FriendsController@addFriend')->name('friends.store');
    Route::get('friends', 'FriendsController@index')->name('friends.index');

});
