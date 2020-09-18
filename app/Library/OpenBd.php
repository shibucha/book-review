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

class OpenBd
{
    public static function openBdIsbn($isbn)
    {

        $isbn =  urlencode($isbn);
        
        $url = 'https://api.openbd.jp/v1/get?isbn='. $isbn .'&pretty';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();
        
        $bodyArray = json_decode($body, true);
        
        return $bodyArray[0];
    }


    public static function OpenBdStore($items,$author,$book,$reading_record,$book_id, $user_id)
    {
        
            $book_id = Book::where('book_id', '=', $book_id)->first();

            // API情報にAuhtorsキーが存在するかチェック
            if ($items['summary']['author']) {
                $author_name = Author::where('author', str_replace(['／著','／原著'],"",$items['summary']['author']))->first();
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
                $author->author = str_replace(['／著','／原著'],"",$items['summary']['author']);                                        
                $author->save();
                $book->author_id = $author->id;
            } else {
                $book->author_id = $author_name->id;
            }

            //書籍情報APIが、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
            //過去既に登録されている本ならば、登録されている書籍のレコードのidを<reading_records>テーブルの<book_id>に登録する。
            if (!isset($book_id)) {
                $book->title = isset($items['summary']['title']) ? $items['summary']['title']: '不明';
                $book->book_id = isset($items['summary']['isbn']) ? $items['summary']['isbn'] : '不明-'.mt_rand(1, 10000);
                $book->image = isset($items['summary']['cover']) ? $items['summary']['cover'] : '';
                $book->description = isset($items['onix']['CollateralDetail']['TextContent'][0]['Text']) ? $items['onix']['CollateralDetail']['TextContent'][0]['Text']: '概要なし';                
                $book->save();
                $reading_record->book_id = $book->id;
            } else {
                $reading_record->book_id = $book_id->id;
            }
        
    }

    public static function getKeyword($request){
        return $request->isbn;
    }
}
