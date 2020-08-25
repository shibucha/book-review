<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;

//レビュー登録処理のデータベース
use App\ReadingRecord;
use App\Book;
use App\Author;

class BookController extends Controller
{
    public function index(){

        $user_id = Auth::id();
        $user = User::find($user_id);
        
        //user_idが登録されているレビューを全取得
        $reviews = ReadingRecord::where('user_id', $user_id)->get();
        
        return view('books.index', [           
            'user' => $user,
            'reviews' => $reviews,
            ]);
    }

    public function create(){
        return view('books.create');
    }
}
