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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/tweetFeed', 'FeedController@showAll');
Route::post('/addTweet', 'FeedController@newTweet');
Route::get('/tweet/showTweet', 'FeedController@showTweet');
Route::post('/tweet/editTweet', 'FeedController@editTweet');
Route::post('/tweet/deleteTweet', 'FeedController@showDeleteQuestion');
Route::get('/tweet/deleteTweet/yes', 'FeedController@deleteTweet');

Route::post('/profile/followUser', 'UserController@followUser');
Route::post('/profile/unfollowUser', 'Usercontroller@unfollowuser');
