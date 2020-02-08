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
Route::post('/tweet/addTweet', 'FeedController@newTweet');
Route::get('/tweet/showTweet', 'FeedController@showTweet');
Route::post('/tweet/editTweet', 'FeedController@editTweet');
Route::post('/tweet/deleteTweet', 'FeedController@showDeleteQuestion');
Route::get('/tweet/deleteTweet/yes', 'FeedController@deleteTweet');

Route::post('/comment/addComment', 'FeedController@newComment');
Route::post('/comment/deleteComment', 'FeedController@deleteComment');
Route::post('/comment/showComment', 'FeedController@showComment');
Route::post('/comment/editComment', 'FeedController@editComment');

Route::post('like/likeTweet', 'FeedController@likeTweet');
Route::post('like/unlikeTweet', 'FeedController@unlikeTweet');

Route::post('/profile/followUser', 'UserController@followUser');
Route::post('/profile/unfollowUser', 'UserController@unfollowuser');
