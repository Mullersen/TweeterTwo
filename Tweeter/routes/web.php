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

Auth::routes();

Route::get('/tweetFeed', 'FeedController@showAll');
Route::get('/tweet/addTweet', 'FeedController@newTweet')->middleware('auth');
Route::post('/tweet/addRetweet', 'FeedController@newRetweet')->middleware('auth');
Route::get('/tweet/showTweet', 'FeedController@showTweet')->middleware('auth');
Route::post('/tweet/editTweet', 'FeedController@editTweet')->middleware('auth');
Route::post('/tweet/deleteTweet', 'FeedController@showDeleteQuestion')->middleware('auth');
Route::get('/tweet/deleteTweet/yes', 'FeedController@deleteTweet')->middleware('auth');

Route::get('/discoveryFeed', 'FeedController@discover')->middleware('auth');

Route::post('/comment/addComment', 'FeedController@newComment')->middleware('auth');
Route::post('/comment/addGifComment', 'FeedController@newGifComment')->middleware('auth');
Route::post('/comment/deleteGifComment','FeedController@deleteGifComment')->middleware('auth');
Route::post('/comment/deleteComment', 'FeedController@deleteComment')->middleware('auth');
Route::post('/comment/showComment', 'FeedController@showComment')->middleware('auth');
Route::post('/comment/editComment', 'FeedController@editComment')->middleware('auth');

Route::post('like/likeTweet', 'FeedController@likeTweet')->middleware('auth');
Route::post('like/unlikeTweet', 'FeedController@unlikeTweet')->middleware('auth');
Route::get('like/myLikes', 'FeedController@getMyLikes')->middleware('auth');

Route::post('/profile/followUser', 'UserController@followUser')->middleware('auth');
Route::post('/profile/unfollowUser', 'UserController@unfollowUser')->middleware('auth');
Route::get('/profile/show/{id}', 'UserController@showProfile');
Route::post('/profile/editEmail', 'UserController@editEmail')->middleware('auth');
Route::post('/profile/editPassword', 'UserController@editPassword')->middleware('auth');
Route::post('/profile/deleteProfile', 'UserController@showDeleteQuestion')->middleware('auth');
Route::post('/profile/deleteProfile/yes', 'UserController@deleteProfile')->middleware('auth');

Route::get('/messages/home', 'MessageController@showMessages')->middleware('auth');
Route::get('/messages/getFollows', 'MessageController@getFollows')->middleware('auth');
Route::post('/messages/getMessages', 'MessageController@getMessages')->middleware('auth');
Route::post('/messages/sendMessage', 'MessageController@sendMessage')->middleware('auth');

Route::get('/', 'HomeController@index');
