<?php

namespace app\Library;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\ReadingRecordRequest;

// Facades
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Model
use App\ReadingRecord;
use App\Book;
use App\Author;
use PharIo\Manifest\Library;

// Facades
use App\Facades\ImageProccesing;
use App\Facades\EnvironmentalConfirmation;

// others
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;


class RakutenBook
{
    private $app_id;

    // わたってきた変数がキーワードか、ISBNコードか検証
    public function veryfyKeywordOrIsbn($keyword)
    {
        if (is_numeric($keyword)) {
            $isbn = $keyword;
            return $this->rakutenBooksIsbn($isbn);
        } else {
            return $this->rakutenBooksKeyword($keyword);
        }
    }

    // ISBNコードで情報を取得
    public function rakutenBooksIsbn($isbn)
    {
        $this->app_id = $this->checkAppId();

        $isbn =  urlencode($isbn);

        $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?format=json&isbn=' . $isbn . '&sort=sales&outOfStockFlag=1&applicationId=' . $this->app_id;

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, false);

        return $items[0] = $bodyArray->Items;
    }

    // キーワードで情報を取得
    public function rakutenBooksKeyword($keyword)
    {
        $this->app_id = $this->checkAppId();

        $keyword = urlencode($keyword);

        $url = 'https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?format=json&title=' . $keyword . '&sort=sales&outOfStockFlag=1&applicationId=' . $this->app_id;

        $client = new Client();

        $response = $client->request("GET", $url);

        $body = $response->getBody();

        $bodyArray = json_decode($body, false);

        return $bodyArray->Items;
    }

    // 楽天ブックのレビュー保存
    public function rakutenBookStore($item, $author, $book, $reading_record, $book_id, $user_id)
    {
        $book_id = Book::where('book_id', $book_id)->first();

        // API情報にAuhtorsキーが存在するかチェック
        if ($item[0]->Item->author) {
            $author_name = Author::where('author', $item[0]->Item->author)->first();
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
            $author->author = $item[0]->Item->author;
            $author->save();
            $book->author_id = $author->id;
        } else {
            $book->author_id = $author_name->id;
        }

        // APIに書籍イメージが含まれていなかった場合の保存先パス
        $book_image_url = ImageProccesing::getBookImagePath();

        //書籍情報APIが、booksテーブルにまだ存在しないならば、書籍情報を保存しておく。
        //過去既に登録されている本ならば、登録されている書籍のレコードのidを<reading_records>テーブルの<book_id>に登録する。
        if (!isset($book_id)) {
            $book->title =  $item[0]->Item->title ?? '不明';
            $book->book_id = $item[0]->Item->isbn ?? '不明-' . mt_rand(1, 10000);
            $book->image = $item[0]->Item->largeImageUrl ?? $book_image_url[1];
            $book->description = $item[0]->Item->itemCaption ?? '概要なし';
            $book->save();
            $reading_record->book_id = $book->id;
        } else {
            $reading_record->book_id = $book_id->id;
        }
    }

    public function checkAppId()
    {
        $env_name = EnvironmentalConfirmation::veryfyEnvironment();
        if ($env_name === "production") {
            return 1079203893539942141;
        } else {
            return 1040536237877869158;
        }
    }
}
