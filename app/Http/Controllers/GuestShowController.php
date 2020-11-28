<?php

namespace App\Http\Controllers;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\ReadingRecordRequest;

// Model
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\ReadingRecord;

// Facades
use App\Facades\RakutenBook;
use App\Facades\ImageProccesing;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class GuestShowController extends Controller
{
    // 詳細ページの表示
    public function show($book_id, ReadingRecord $reading_record)
    {
        $user_id = Auth::id();
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
        if (empty($items)) {
            return redirect()->route('books.index');
        }

        // これまでレビュー登録があったかどうかの確認
        $book = Book::where('book_id', $book_id)->first();

        if ($book === null) {
            // 過去にレビューされたことのない本の場合は、以下のページに飛ぶ。             
            return redirect()->route('guest.nothingToShow', ['book_id' => $book_id]);
        }

        // レビュー取得
        $others_reviews = ReadingRecord::with(['user', 'user.myProfile', 'book'])->where('book_id', $book->id)->whereNotIn('public_private', [0])->orderBy('created_at', 'desc')->paginate(30);

        // その本のレビュー数をカウント
        $review_count = ReadingRecord::with('book')->where('book_id', $book->id)->count();

        //本の評価数値を取得
        $rating = ReadingRecord::where('book_id', $book->id)->select('rating')->get()->avg('rating');

        $book_image_path = ImageProccesing::getBookImagePath();

        return view('books.guests.guest-show', [
            'items' => $items,
            'message' => $message,
            'book' => $book,
            'others_reviews' => $others_reviews,
            'review_count' => $review_count,
            'reading_record' => $reading_record,
            'user_id' => $user_id,
            'rating' => $rating,
            'book_image_path' => $book_image_path['book_url'],
        ]);
    }

    // まだ誰もレビューしたことのない本の場合
    public function nothingToShow($book_id)
    {
        $items = null;

        //書籍情報取得(App\Library)
        if (isset($book_id)) {
            $items = RakutenBook::rakutenBooksIsbn($book_id);
            $message = null;
        }
        $book_image_path = ImageProccesing::getBookImagePath();
        return view('books.guests.nothing-to-show', [
            'items' => $items,
            'book_image_path' => $book_image_path['book_url'],
        ]);
    }
}
