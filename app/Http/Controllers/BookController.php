<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Library\GoogleBook;
use App\User;

//レビュー登録処理のデータベース
use App\ReadingRecord;
use App\Book;
use App\Author;

class BookController extends Controller
{
    public function index(Book $book)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);

        //user_idが登録されているレビューを全取得
        $reviews = ReadingRecord::where('user_id', $user_id)->get();
       

        return view('books.index', [
            'user' => $user,
            'reviews' => $reviews,          
        ]);
    }

    public function show($book_id){
        $items = null;

        if(isset($book_id)){
            $items = GoogleBook::googleBooksKeyword($book_id);
            $message = null;
        } 
        if(!isset($items)){
            $message = '本が選択されていません。';
        }

        return view('books.show',[
            'items' => $items,
            'message' => $message
        ]);
    }
}
