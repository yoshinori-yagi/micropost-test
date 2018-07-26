<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|qq
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MicropostsController@index');

Route::get('welcome', function () { return view('welcome');
});

Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');

Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::get('members', 'UsersController@members')->name('users.members');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'users']]);
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    
    Route::resource('microposts', 'MicropostsController', ['only' => ['index', 'show']]);
    Route::group(['prefix' => 'microposts/{id}'], function () {
        Route::post('favorite', 'FavoriteController@store')->name('user.favorite'); 
        Route::delete('unfavorite', 'FavoriteController@destroy')->name('user.unfavorite'); 
        Route::get('favorings', 'UsersController@favorings')->name('users.favorings'); 
        
        Route::post('retweet', 'RetweetController@store')->name('user.retweet'); 
        Route::delete('unretweet', 'RetweetController@destroy')->name('user.unretweet'); 
        Route::get('retweetings', 'UsersController@retweetings')->name('users.retweetings'); 
    });
    
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
    
    
});

# Instagram login
Route::get('/instagram/', 'InstagramController@instagramLogin')->name('instagram.login');

# Instagram callback
Route::get('/instagram/callback/', 'InstagramController@instagramCallback');