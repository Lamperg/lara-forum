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
    Route::get('{thread}', 'ThreadController@show')->name('show');
    Route::post('{thread}/replies', 'ReplyController@store')->name('replies_store');
});
