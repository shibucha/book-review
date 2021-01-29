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

//お問い合わせ
Route::get('/contacts/index', 'ContactController@index')->name('contacts.index');
Route::post('/contacts/confirm', 'ContactController@confirm')->name('contacts.confirm');
Route::post('/contacts/complete', 'ContactController@complete')->name('contacts.complete');

// 利用規約
Route::get('/term', 'TermController@index')->name('term');

// ゲストはレビューのみ閲覧可
Route::get('/books/guest/show/{book_id}', 'GuestShowController@show')->name('guest.show');
Route::get('/books/guest/nothing-to-show/{book_id}', 'GuestShowController@nothingToShow')->name('guest.nothingToShow');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/books/{user_id?}', 'BookController@index')->name('books.index');

    // *************書籍の検索〜登録までの操作関連 **********//
    Route::post('/books/{book_id}/search', 'SearchController@store')->name('search.store');
    Route::get('/books/{book_id}/show', 'BookController@show')->name('books.show');
    Route::get('/books/{book_id}/nothing-to-show', 'BookController@nothingToShow')->name('books.nothingToShow');

    // *************レビュー操作関連 **********//
    Route::put('/books/{reading_record_id}/like', 'BookController@like')->name('books.like');
    Route::delete('/books/{reading_record_id}/like', 'BookController@unlike')->name('books.unlike');
    Route::patch('/books/{reading_record_id}/update', 'BookController@update')->name('books.update');
    Route::delete('/books/{reading_record_id}/delete', 'BookController@destroy')->name('books.delete');

    // *************読書履歴関連 **********//
    Route::get('/curious-book/index', 'CuriousBookController@index')->name('curious.index');
    Route::post('/curious-book/{book_isbn}/update', 'CuriousBookController@update')->name('curious.update');    

    // **************設定関連************** //
    //アイコン   
    Route::get('/books/{user_id}/icon', 'MyIconController@index')->name('settings.icon');
    Route::post('/books/{user_id}/icon', 'MyIconController@store');
    Route::delete('/books/{user_id}/icon', 'MyIconController@destroy')->name('settings.icon.destroy');
    // マイプロフィール
    Route::get('books/settings/my-profile', 'MyProfileController@index')->name('settings.my_profile');
    Route::patch('books/settings/{user_id}/my-profile', 'MyProfileController@update')->name('settings.my_profile_update');
    // 退会
    Route::get('books/settings/resign', 'ResignController@index')->name('settings.resign');
    Route::delete('books/settings/resign', 'ResignController@destroy')->name('settings.resign');
});
