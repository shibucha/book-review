<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use App\Http\Requests\ReadingRecordRequest;
use Illuminate\Support\Facades\Auth;
use App\ReadingRecord;
use App\Book;
use App\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class GoogleBook
{

    // キーワード検索による結果の取得
    public static function googleBooksKeyword($keyword)
    {

        $keyword = urlencode($keyword);

        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $keyword . '&maxResults=30&country=JP&tbm=bks';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['items'];
    }

    // 該当する書籍のみ取得
    public static function getGoogleBookItem($book_id)
    {
        $keyword = urlencode($book_id);

        $url = 'https://www.googleapis.com/books/v1/volumes/' . $book_id;

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);
        
        return $bodyArray;
    }

    // googleブックスの保存メソッド
    public static function googleBookStore($item, $author, $book, $reading_record, $book_id, $user_id)
    {
        
            $book_id = Book::where('book_id', '=', $book_id)->first();

            // API情報にAuhtorsキーが存在するかチェック
            if (array_key_exists('authors', $item['volumeInfo'])) {
                $author_name = Author::where('author', '=', $item['volumeInfo']['authors'][0])->first();
            } else {
                $author_name = "不明";
            }

            //もし既に登録した本を登録しようとしたら、トップページにリダイレクトする。
            if (isset($book_id)) {
                $registered_check = ReadingRecord::where('user_id', $user_id)->where('book_id', $book_id->id)->first();
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
            if (!isset($book_id)) {
                $book->title = $item['volumeInfo']['title'];
                $book->book_id = $item['id'];
                $book->image = $item['volumeInfo']['imageLinks']['thumbnail'];
                $book->description = $item['volumeInfo']['description'];
                $book->save();
                $reading_record->book_id = $book->id;
            } else {
                $reading_record->book_id = $book_id->id;
            }
        
    }

    public static function getKeyword($request)
    {
        return $request->keyword;
    }
}
