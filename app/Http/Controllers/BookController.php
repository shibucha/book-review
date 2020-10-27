<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\ReadingRecordRequest;

// Model
use App\User;
use App\Book;
use App\Author;
use App\ReadingRecord;

// Library
use App\Library\GoogleBook;
use App\Library\OpenBd;
use App\Library\BookReviewCommon;
use App\Library\RakutenBook;
use App\Library\ImageProccesing;

class BookController extends Controller
{
    public function index(Book $book, $user_id = 0)
    {
        if ($user_id === 0) {
            $user_id = Auth::id();
        } else {
            $user_id = $user_id;
        }
        $user = User::find($user_id);

        //user_idが登録されているレビューを全取得
        $reviews = ReadingRecord::where('user_id', $user_id)->paginate(8);
        $reviews->load('book');
        $number_of_readings = ReadingRecord::where('user_id', $user_id)->count();
        $reviews_count = ReadingRecord::where('user_id', $user_id)->select('body')->whereNotIn('body', ['null'])->count();
        $image_path = ImageProccesing::getIconImagePath();

        return view('books.index', [
            'user' => $user,
            'reviews' => $reviews,
            'number_of_readings' => $number_of_readings,
            'reviews_count' => $reviews_count,
            'icon_url' => $image_path['icon_url'],
        ]);
    }

    // 詳細ページの表示
    public function show($book_id, ReadingRecord $reading_record)
    {
        // ddd($book_id);
        $user_id = Auth::id();
        $user = User::with('myProfile')->find($user_id);       
        $items = null;

        //書籍情報取得(App\Library)
        if (isset($book_id)) { 
            $items = RakutenBook::rakutenBooksIsbn($book_id);
            $message = null;
        } else {
            return redirect()->route('books.index');
        }
        if (!isset($items)) {
            $message = '本が選択されていません。';
        }
        
        // アイテムが空の場合（ISBNコードに誤りがあるか、楽天ブックスに登録されていないか）、マイページにリダイレクト
        if(empty($items)){
            return redirect()->route('books.index');
        }

        // これまでレビュー登録があったかどうかの確認
        $book = Book::where('book_id', $book_id)->first();

        if ($book === null) {
            // 過去にレビューされたことのない本の場合は、以下のページに飛ぶ。             
            return redirect()->route('books.nothingToShow', ['book_id' => $book_id]);
        } else {
            $review = ReadingRecord::with('likes')->where('user_id', $user_id)->where('book_id', $book->id)->first();
        }

        // 他人のレビュー取得
        $others_reviews = ReadingRecord::with(['user','user.myProfile','book','likes'])->where('book_id', $book->id)->whereNotIn('user_id', [$user_id])->whereNotIn('public_private', [0])->orderBy('created_at', 'desc')->paginate(30);
                            
        // その本のレビュー数をカウント
        $review_count = ReadingRecord::with('book')->where('book_id', $book->id)->count();       

        //本の評価数値を取得
        $rating = ReadingRecord::where('book_id', $book->id)->select('rating')->get()->avg('rating');

        $book_image_path = ImageProccesing::getBookImagePath();

        return view('books.show', [
            'items' => $items,
            'message' => $message,
            'book' => $book,
            'review' => $review,
            'others_reviews' => $others_reviews,
            'review_count' => $review_count,
            'reading_record' => $reading_record,
            'user' => $user,
            'user_id' => $user_id,
            'rating' => $rating,
            'book_image_path' => $book_image_path['book_url'],
        ]);
    }

    // まだ誰もレビューしたことのない本の場合
    public function nothingToShow($book_id)
    {
        $items = null;
        // $google_book = new GoogleBook();

        //書籍情報取得(App\Library)
        if (isset($book_id)) {   
            $items = RakutenBook::rakutenBooksIsbn($book_id);
            $message = null;
        }
        $book_image_path = ImageProccesing::getBookImagePath();
        return view('books.nothing-to-show', [
            'items' => $items, 
            'book_image_path' => $book_image_path['book_url'],
            ]);
    }

    // レビューの編集
    public function update(int $reading_record_id, ReadingRecordRequest $request)
    {
        $reading_record = ReadingRecord::find($reading_record_id);
        $reading_record->fill($request->all())->save();
        return redirect()->route('books.index');
    }

    // レビューの削除
    public function destroy(int $reading_record_id)
    {
        $reading_record = ReadingRecord::find($reading_record_id);
        $reading_record->delete();
        return redirect()->route('books.index');
    }

    // いいね機能
    public function like($reading_record_id, Request $request)
    {

        $reading_record = ReadingRecord::find($reading_record_id);

        $reading_record->likes()->detach($request->user()->id);
        $reading_record->likes()->attach($request->user()->id);

        return [
            'countLikes' => $reading_record->count_likes,
        ];
    }

    // いいね外す
    public function unlike($reading_record_id, Request $request)
    {

        $reading_record = ReadingRecord::find($reading_record_id);

        $reading_record->likes()->detach($request->user()->id);

        return [
            'countLikes' => $reading_record->count_likes,
        ];
    }
}
