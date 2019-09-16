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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('threads/')->name('threads.')->group(function () {
    Route::get('/', 'ThreadController@index')->name('index');
    Route::post('/', 'ThreadController@store')->name('store');
    Route::get('/create', 'ThreadController@create')->name('create');
    Route::get('{channel}', 'ThreadController@index')->name('channel_index');
    Route::get('{channel}/{thread}', 'ThreadController@show')->name('show');
    Route::delete('{channel}/{thread}', 'ThreadController@destroy')->name('destroy');
    Route::post('{channel}/{thread}/replies', 'ReplyController@store')->name('replies_store');
});

Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('replies.favorite_store');

Route::get('profiles/{user}', 'ProfileController@show')->name('profiles.show');
