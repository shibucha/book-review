<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Library\GoogleBook;
use App\Http\Requests\ReadingRecordRequest;
use Illuminate\Support\Facades\Auth;
use App\ReadingRecord;
use App\Book;
use App\Author;
use App\Library\OpenBd;
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
        // dd($google_book_ids);    

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
            $items = GoogleBook::googleBooksKeyword($book_id);

            foreach ($items as $item) {
                $google_book_id = Book::where('google_book_id', '=', $book_id)->first();

                // API情報にAuhtorsキーが存在するかチェック
                if (array_key_exists('authors', $item['volumeInfo'])) {
                    $author_name = Author::where('author', '=', $item['volumeInfo']['authors'][0])->first();
                } else {
                    $author_name = "不明";
                }

                //もし既に登録した本を登録しようとしたら、トップページにリダイレクトする。
                if (isset($google_book_id)) {
                    $registered_check = ReadingRecord::where('user_id', $user_id)->where('book_id', $google_book_id->id)->first();
                }
                if (isset($registered_check)) {
                    return redirect()->route('books.index');
                }

                //API情報に著者が含まれていなかった場合
                if ($author_name === "不明") {

                    $author_name = Author::where('author', '不明')->first();
                    if (isset($author_name)) {
                        $book->author_id = $author_name->id;
                    } else {
                        $author->author = "不明";
                        $author->save();
                        $author_name = $author->author;
                    }
                }


                //著者が既にテーブルに存在しているか確認する。
                if (!isset($author_name)) {
                    $author->author = $item['volumeInfo']['authors'][0];
                    $author->save();
                    $book->author_id = $author->id;
                } else {
                    $book->author_id = $author_name->id;
                }

                //書籍情報APIが、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
                //過去既に登録されている本ならば、登録されている書籍のレコードのidを<reading_records>テーブルの<book_id>に登録する。
                if (!isset($google_book_id)) {
                    $book->title = $item['volumeInfo']['title'];
                    $book->google_book_id = $item['id'];
                    $book->image = $item['volumeInfo']['imageLinks']['thumbnail'];
                    $book->description = $item['volumeInfo']['description'];
                    $book->save();
                    $reading_record->book_id = $book->id;
                } else {
                    $reading_record->book_id = $google_book_id->id;
                }
            }
        }


        //ユーザーが入力した情報の登録。
        $reading_record->fill($request->all());
        $reading_record->user_id = $request->user()->id;
        $reading_record->save();

        return redirect()->route('books.index');
    }
}
