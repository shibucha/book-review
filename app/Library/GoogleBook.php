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

    public static function veryfyIsbnOrGoogleBookId($book_id)
    {   
        
        if(is_numeric($book_id)){
            return self::getGoogleBookItemByIsbn($book_id);
        } else {
            return self::getGoogleBookItem($book_id);
        }
    }

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

        $book_id = urlencode($book_id);

        $url = 'https://www.googleapis.com/books/v1/volumes/' . $book_id;

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray;
    }

    //ISBNコードで書籍を取得
    public static function getGoogleBookItemByIsbn($book_id)
    {

        $book_id = urlencode($book_id);

        $url = $url = $url = 'https://www.googleapis.com/books/v1/volumes?q=' . $book_id;

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, true);

        return $bodyArray['items'][0];
    }

    // googleブックスの保存メソッド
    public static function googleBookStore($item, $author, $book, $reading_record, $book_id, $user_id)
    {
        $google_book = new GoogleBook;

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
            $book->book_id = $google_book->getBookId($item);
            $book->image = $google_book->getGoogleBookImage($item);
            $book->description = $google_book->getGoogleBookDescription($item);
            $book->save();
            $reading_record->book_id = $book->id;
        } else {
            $reading_record->book_id = $book_id->id;
        }
    }

    // ISBNまたはキーワードで検索された場合の検証メソッド(2020/9/19（土）現時点ではキーワードのみの対応)
    public static function getKeyword($request)
    {
        return $request->keyword;
    }

    // API情報にISBNコードが登録されていれば、ISBNコードを返し、登録されていなければ、VolumeIDを返す。
    private function getBookId($item)
    {
        if (array_key_exists('industryIdentifiers', $item['volumeInfo'])) {

            // ISBN_13のコードを取得するための検証
            if (array_key_exists(0, $item['volumeInfo']['industryIdentifiers'])) {

                if (in_array("ISBN_13", $item['volumeInfo']['industryIdentifiers'][0])) {
                    return $item['volumeInfo']['industryIdentifiers'][0]['identifier'];
                }
            }

            // ISBN_13のコードを取得するための検証
            if (array_key_exists(1, $item['volumeInfo']['industryIdentifiers'])) {

                if (in_array("ISBN_13", $item['volumeInfo']['industryIdentifiers'][1])) {
                    return $item['volumeInfo']['industryIdentifiers'][1]['identifier'];
                }
            }

            // コードがOtherの場合はVolumeIDを返す
            if (array_key_exists(0, $item['volumeInfo']['industryIdentifiers'])) {

                if (in_array("OTHER", $item['volumeInfo']['industryIdentifiers'][0])) {
                    return $item['id'];
                }
            }

            // コードがOtherの場合はVolumeIDを返す
            if (array_key_exists(1, $item['volumeInfo']['industryIdentifiers'])) {

                if (in_array("OTHER", $item['volumeInfo']['industryIdentifiers'][1])) {
                    return $item['id'];
                }
            }
        } else {
            return $item['id'];
        }
    }

    // API情報にDescriptionが含まれているか検証。
    private function getGoogleBookDescription($item)
    {
        return
            array_key_exists('description', $item['volumeInfo']) ? $item['volumeInfo']['description'] : 'なし';
    }

    private function getGoogleBookImage($item)
    {
        return
            array_key_exists('imageLinks', $item['volumeInfo']) ? $item['volumeInfo']['imageLinks']['thumbnail'] : "";
    }
}
