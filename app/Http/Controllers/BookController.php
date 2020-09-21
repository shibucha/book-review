<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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


class BookController extends Controller
{
    public function index(Book $book)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);

        //user_idが登録されているレビューを全取得
        $reviews = ReadingRecord::where('user_id', $user_id)->paginate(15);
        $reviews->load('book');
        $reviews_count = ReadingRecord::where('user_id', $user_id)->count();

        return view('books.index', [
            'user' => $user,
            'reviews' => $reviews,
            'reviews_count' => $reviews_count,
        ]);
    }

    // 詳細ページの表示
    public function show($book_id, ReadingRecord $reading_record)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $google_book = new GoogleBook();
        $item = null;
        
        //書籍情報取得(App\Library)
        if (isset($book_id)) {
            $item = $google_book->veryfyIsbnOrGoogleBookId($book_id);
            // $item = OpenBd::getOpenBdItemByIsbn($book_id);
            
            $message = null;
        }
        if (!isset($item)) {
            $message = '本が選択されていません。';
        }

        // これまでレビュー登録があったかどうかの確認
        $book = Book::where('book_id', $google_book->getBookId($item))->first();
        // $book = Book::where('book_id', $book_id)->first();
        if ($book === null) {
            // 過去にレビューされたことのない本の場合は、以下のページに飛ぶ。             
            return redirect()->route('books.nothingToShow', ['book_id' => $book_id]);
        } else {
            $review = ReadingRecord::where('user_id', $user_id)->where('book_id', $book->id)->first();
        }

        // 他人のレビュー取得
        $others_reviews = ReadingRecord::where('book_id', $book->id)->whereNotIn('user_id', [$user_id])->whereNotIn('public_private', [0])->get();

        // その本のレビュー数をカウント
        $review_count = ReadingRecord::where('book_id', $book->id)->count();
       
        return view('books.show', [
            'item' => $item,
            'message' => $message,
            'book' => $book,
            'review' => $review,
            'others_reviews' => $others_reviews,
            'review_count' => $review_count,
            'reading_record' => $reading_record,
            'user' => $user,
            'user_id' => $user_id
        ]);
    }

    // まだ誰もレビューしたことのない本の場合
    public function nothingToShow($book_id)
    {
        $item = null;
        $google_book = new GoogleBook();

        //書籍情報取得(App\Library)
        if (isset($book_id)) {
            // $item = OpenBd::getOpenBdItemByIsbn($book_id);            
            $item = $google_book->veryfyIsbnOrGoogleBookId($book_id);            
            $message = null;
        }

        return view('books.nothing-to-show', ['item' => $item]);
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
