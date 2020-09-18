<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\ReadingRecordRequest;

// Library
use App\Library\GoogleBook;
use App\Library\OpenBd;
use App\Library\BookReviewCommon;

// Model
use App\ReadingRecord;
use App\Book;
use App\Author;

// Pagination
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{

    //本の検索結果を表示
    public function index(SearchRequest $request, ReadingRecord $reading_record)
    {
        $user_id = Auth::id();
        $items = null;
        $keyword = $request->keyword;
        // ddd($keyword);

        //書籍APIの利用(App\Library)
        $items = GoogleBook::googleBooksKeyword($keyword);

        // ページネーション(App\Libraryの汎用クラスを使用)
        $items = BookReviewCommon::setPagination($items, 10, $request);

        //既に登録した本のbook_idを取得
        if (isset($user_id)) {
            $reviewed_books = ReadingRecord::with('book')->where('user_id', $user_id)->get();

            //今までに本を登録しているか確認。
            if ($reviewed_books->count() > 0) {
                foreach ($reviewed_books as $book) {
                    $book_ids[] = $book->book->book_id;
                }
            } else {
                $book_ids[] = null;
            }
        } else {
            //未ログインユーザーの場合
            $book_ids[] = null;
        }

        // 値の中身を確認          
        
        return view('books.search', [
            'items' => $items,
            'keyword' => $keyword,            
            'user_id' => $user_id,
            'book_ids' => $book_ids,
        ]);
    }

    //本の感想登録
    public function store($book_id, ReadingRecordRequest $request, ReadingRecord $reading_record, Book $book, Author $author)
    {
        $items = null;
        $user_id = Auth::id();


        //登録する書籍のAPI情報を取得
        if (isset($book_id)) {

            // 書籍情報を取得（App\Library\）
            $items = GoogleBook::googleBooksKeyword($book_id);

            // 書籍情報を保存（App\Library\）
            GoogleBook::googleBookStore($items, $author, $book, $reading_record, $book_id, $user_id);
        }


        //ユーザーが入力した情報の登録。
        $reading_record->fill($request->all());
        $reading_record->user_id = $request->user()->id;
        $reading_record->save();

        return redirect()->route('books.index');
    }
}
