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

// 書籍検索は、未ログイン（ゲストユーザー）でも閲覧可能
Route::get('/books/search', 'SearchController@index')->name('books.search');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/books', 'BookController@index')->name('books.index');
    Route::get('/books/{user_id}/profile', 'ProfileController@index')->name('books.profile');
    Route::post('/books/{user_id}/profile', 'ProfileController@store');
    Route::delete('/books/{user_id}/profile', 'ProfileController@destroy')->name('books.profile.destroy');
    Route::post('/books/{book_id}/search', 'SearchController@store')->name('search.store');
    Route::get('/books/{book_id}/show', 'BookController@show')->name('books.show');
    Route::patch('/books/{reading_record_id}/update', 'BookController@update')->name('books.update');  
    Route::delete('/books/{reading_record_id}/delete', 'BookController@destroy')->name('books.delete');  
});



