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
        $google_book = new GoogleBook();
        $keyword = $google_book->getKeyword($request);      
        // $keyword = OpenBd::getKeyword($request);
      
        if (isset($keyword)) {
            //書籍APIの利用(App\Library)
            // $items = OpenBd::getOpenBdItemByIsbn($keyword);
            $items = $google_book->googleBooksSearchResults($keyword);
            
            if (!$items) {
                return redirect()->route('books.search');
            }

            // ページネーション(App\Libraryの汎用クラスを使用)
            $items = BookReviewCommon::setPagination($items, 10, $request);
        }


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
        
        return view('books.search', [
            'items' => $items,
            'keyword' => $keyword,
            'user_id' => $user_id,
            'book_ids' => $book_ids,
            'google_book' => $google_book,
        ]);
    }

    //本の感想登録
    public function store($book_id, ReadingRecordRequest $request, ReadingRecord $reading_record, Book $book, Author $author)
    {
        $item = null;
        $user_id = Auth::id();
        $google_book = new GoogleBook();

        //登録する書籍のAPI情報を取得
        if (isset($book_id)) {

            // 書籍情報を取得（App\Library\）
            // $item = OpenBd::getOpenBdItemByIsbn($book_id);
            $item = $google_book->veryfyIsbnOrGoogleBookId($book_id);

            // 書籍情報を保存（App\Library\）
            // OpenBd::OpenBdStore($item, $author, $book, $reading_record, $book_id, $user_id);
            $google_book->googleBookStore($item, $author, $book, $reading_record, $book_id, $user_id);
        }


        //ユーザーが入力した情報の登録。
        $reading_record->fill($request->all());
        $reading_record->user_id = $request->user()->id;
        $reading_record->save();

        return redirect()->route('books.index');
    }
}
