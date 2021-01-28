<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
use App\Models\CuriousBook;
use App\Models\Book;

use App\Library\CuriousBookService;

// Facade
use App\Facades\RakutenBook;
use Illuminate\Support\Facades\Auth;

class CuriousBookController extends Controller
{
    private $curious_book;

    public function __construct()
    {
        $this->curious_book =  new CuriousBook();
    }

    public function index()
    {
        $curious_books = $this->curious_book->with(['book'])->where('user_id', Auth::user()->id)->paginate(6);
        return view('curious-books.index', ['curious_books' => $curious_books]);
    }

    // 読みたい本に追加
    public function update($book_isbn)
    {
        $curious_book_service = new CuriousBookService($book_isbn);
        $book_id = $curious_book_service->storeCuriousBook();

        $curious_book = CuriousBook::where('user_id', Auth::user()->id)->where('book_id', $book_id)->first();

        /*
        @ボタンを押した際の挙動        
        <読みたい本のリストから削除>既に登録済みのレコード削除
        <読みたい本のリストに追加>新規レコードの追加
        */        
        $this->curious_book->pushCuriousBtn($curious_book,$book_id);      

        return redirect()->route('curious.index');
    }
}
