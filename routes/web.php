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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', 'HomeController@index')->name('index');
// Route::resource('/books', 'BookController')->middleware('auth'); 後からミドルウェアを実装。
Route::group(['middleware'=>'auth'], function(){
    Route::get('/books/profile', 'ProfileController@index')->name('books.profile');
    Route::post('/books/profile', 'ProfileController@store');
    Route::resource('/books', 'BookController');
});