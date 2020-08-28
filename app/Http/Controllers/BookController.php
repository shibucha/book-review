<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReadingRecordRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Library\GoogleBook;
use App\User;
use App\Book;
use App\Author;

//レビュー登録処理のデータベース
use App\ReadingRecord;

class BookController extends Controller
{
    public function index(Book $book)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);

        //user_idが登録されているレビューを全取得
        $reviews = ReadingRecord::where('user_id', $user_id)->get();
       

        return view('books.index', [
            'user' => $user,
            'reviews' => $reviews,          
        ]);
    }

    public function show($book_id)
    {
        $user_id = Auth::id();
       
        $items = null;
        $book = Book::where('google_book_id',$book_id)->first();
        $review = ReadingRecord::where('user_id', $user_id)->where('book_id', $book->id)->first();
        $others_reviews = ReadingRecord::where('book_id', $book->id)->whereNotIn('user_id', [$user_id])->get();
        $review_count = ReadingRecord::where('book_id', $book->id)->count();

        //グーグルブックスの書籍情報取得
        if(isset($book_id)){
            $items = GoogleBook::googleBooksKeyword($book_id);
            $message = null;
        } 
        if(!isset($items)){
            $message = '本が選択されていません。';
        }

        return view('books.show',[
            'items' => $items,
            'message' => $message,
            'book' => $book,
            'review' => $review,
            'others_reviews' => $others_reviews,
            'review_count' => $review_count
        ]);
    }

    public function update(int $reading_record_id, ReadingRecordRequest $request){

        $reading_record = ReadingRecord::find($reading_record_id);
        $reading_record->fill($request->all())->save();
        return redirect()->route('books.index');
    }
}
