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

        //レビュー登録しようとする書籍のIDを変数に代入。※$item['id']
        $google_book_id = Book::where('google_book_id','=', $book_id)->first();

        //登録する書籍のAPI情報を取得
        if (isset($book_id)) {
            $items = GoogleBook::googleBooksKeyword($book_id);
        }

        foreach ($items as $item) {

            //著者が既にテーブルに存在しているか確認する。
            if (Author::where('author', $item['volumeInfo']['authors'][0])->exists()) {
                $book->author_id = Author::where('author', '=', $item['volumeInfo']['authors'][0])->id;                
            } else {
                $author->author = $item['volumeInfo']['authors'][0];
            }

            //API情報が、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
            if (!isset($google_book_id)) {
                $book->title = $item['volumeInfo']['title'];
                $book->google_book_id = $book_id;
                $book->published_date = $item['volumeInfo']['publishedDate'];
            }
        }


        //API情報が既にデータベースに存在しているならば、booksテーブルに登録はしない。
        if (isset($google_book_id)) {
            $reading_record->book_id = $google_book_id;
        }

        //ユーザーが入力した情報の登録。
        $reading_record->reading_date = $request->reading_date;
        $reading_record->body = $request->body;
        $reading_record->user_id = $request->user()->id;
        $reading_record->book_id = $book_id;
        $reading_record->save();
        $author->save();
        $book->save();

        return redirect()->route('books.index');
    }
}
