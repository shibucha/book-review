<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;

// Model
// use App\Models\CuriousBook;
use App\Models\Book;
use App\Library\CuriousBook;
// Facade
use App\Facades\RakutenBook;

class CuriousBookController extends Controller
{
    public function index()
    {
        return view('curious-books.index');
    }

    // 読みたい本に追加
    public function update($book_id)
    {
        $book = new CuriousBook($book_id);
        $book->storeCuriousBook();
        return redirect()->route('curious.index');
    }

    // 読んだor読みたい本リストから削除
    public function delete()
    {
    }
}
