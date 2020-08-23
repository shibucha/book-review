<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Library\GoogleBook;
use App\Http\Requests\ReadingRecordRequest;
use App\ReadingRecord;
use App\Book;
use App\Author;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $items = null;
        $keyword = $request->keyword;

        if (!empty($keyword)) {
            //グーグルブックスの利用
            $items = GoogleBook::googleBooksKeyword($keyword);
        }
        return view('books.search', [
            'items' => $items,
            'keyword' => $keyword,
        ]);
    }

    public function store($book_id, ReadingRecordRequest $request, ReadingRecord $reading_record, Book $book, Author $author)
    {
        $items = null;


        //登録する書籍のAPI情報を取得
        if (isset($book_id)) {
            $items = GoogleBook::googleBooksKeyword($book_id);

            foreach ($items as $item) {
                $google_book_id = Book::where('google_book_id', '=', $book_id)->first();
                $author_name = Author::where('author', '=', $item['volumeInfo']['authors'][0])->first();

                //著者が既にテーブルに存在しているか確認する。
                if (!isset($author_name)) {
                    $author->author = $item['volumeInfo']['authors'][0];
                    $author->save();
                    $book->author_id = $author->id;              
                } else {
                    $book->author_id = $author_name->id;
                }

                //API情報が、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
                if (!isset($google_book_id)) {                                
                    $book->title = $item['volumeInfo']['title'];
                    $book->google_book_id = $item['id'];
                    $book->image = $item['volumeInfo']['imageLinks']['thumbnail'];
                    $book->description = $item['volumeInfo']['description'];
                    $book->published_date = $item['volumeInfo']['publishedDate'];
                }
            }
        }

        $book->save();

        //ユーザーが入力した情報の登録。
        $reading_record->reading_date = $request->reading_date;
        $reading_record->body = $request->body;
        $reading_record->user_id = $request->user()->id;
        $reading_record->book_id = $book->id;
        $reading_record->save();



        return redirect()->route('books.index');
    }
}
