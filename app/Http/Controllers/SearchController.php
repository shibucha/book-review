<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\GoogleBook;
use App\Library\OpenBd;
use App\Http\Requests\ReadingRecordRequest;
use Illuminate\Support\Facades\Auth;
use App\ReadingRecord;
use App\Book;
use App\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{

    //本の検索結果を表示
    public function index(Request $request, ReadingRecord $reading_record)
    {
        $user_id = Auth::id();
        $items = null;
        $keyword = $request->keyword;


        if (isset($keyword)) {
            //書籍APIの利用(App\Libraryの汎用クラスを使用)            
            $items = OpenBd::openBdIsbn($keyword);            
            $items = collect($items);
           
            // ペジネーションの実装
            $items = new LengthAwarePaginator(
                $items->forPage($request->page, 10),
                $items->count(),
                10,
                $request->page,
                ['path' => $request->url()]
            );
        }


        //既に登録した本のgoogle_book_idを取得
        if (isset($user_id)) {
            $reviewed_books = ReadingRecord::with('book')->where('user_id', $user_id)->get();

            //今までに本を登録しているか確認。
            if ($reviewed_books->count() > 0) {
                foreach ($reviewed_books as $book) {
                    $google_book_ids[] = $book->book->google_book_id;
                }
            } 
            else 
            {
                $google_book_ids[] = null;
            }

        } 
        else 
        {
            //未ログインユーザーの場合
            $google_book_ids[] = null;
        }

        // 値の中身を確認          
       
        return view('books.search', [
            'items' => $items,           
            'keyword' => $keyword,
            'user_id' => $user_id,
            'google_book_ids' => $google_book_ids,
        ]);
    }

    //本の感想登録
    public function store($book_id, ReadingRecordRequest $request, ReadingRecord $reading_record, Book $book, Author $author)
    {
        $items = null;
        $user_id = Auth::id();


        //登録する書籍のAPI情報を取得
        if (isset($book_id)) {
            $items = OpenBd::openBdIsbn($book_id);
            OpenBd::OpenBdStore($items,$author,$book,$reading_record,$book_id, $user_id);            
        }


        //ユーザーが入力した情報の登録。
        $reading_record->fill($request->all());
        $reading_record->user_id = $request->user()->id;
        $reading_record->save();

        return redirect()->route('books.index');
    }
}
