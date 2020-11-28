<?php

namespace app\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

use App\Http\Requests\ReadingRecordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\ReadingRecord;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

class OpenBd
{
    public static function getOpenBdItemByIsbn($isbn)
    {

        $isbn =  urlencode($isbn);
        
        $url = 'https://api.openbd.jp/v1/get?isbn='. $isbn .'&pretty';

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();
        
        $bodyArray = json_decode($body, true);
        
        return $bodyArray[0];
    }


    public static function OpenBdStore($item,$author,$book,$reading_record,$book_id, $user_id)
    {
        
            $book_id = Book::where('book_id', '=', $book_id)->first();

            // API情報にAuhtorsキーが存在するかチェック
            if ($item['summary']['author']) {
                $author_name = Author::where('author', str_replace(['／著','／原著'],"",$item['summary']['author']))->first();
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
                $author->author = str_replace(['／著','／原著'],"",$item['summary']['author']);                                        
                $author->save();
                $book->author_id = $author->id;
            } else {
                $book->author_id = $author_name->id;
            }

            //書籍情報APIが、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
            //過去既に登録されている本ならば、登録されている書籍のレコードのidを<reading_records>テーブルの<book_id>に登録する。
            if (!isset($book_id)) {
                $book->title = isset($item['summary']['title']) ? $item['summary']['title']: '不明';
                $book->book_id = isset($item['summary']['isbn']) ? $item['summary']['isbn'] : '不明-'.mt_rand(1, 10000);
                $book->image = isset($item['summary']['cover']) ? $item['summary']['cover'] : '';
                $book->description = isset($item['onix']['CollateralDetail']['TextContent'][0]['Text']) ? $item['onix']['CollateralDetail']['TextContent'][0]['Text']: '概要なし';                
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
