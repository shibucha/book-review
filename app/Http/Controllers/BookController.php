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
use App\Library\OpenBd;
use App\ReadingRecord;

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

        $items = null;
        
        //グーグルブックスの書籍情報取得
        if(isset($book_id)){
            $items = OpenBd::openBdIsbn($book_id);
            $message = null;
        } 
        if(!isset($items)){
            $message = '本が選択されていません。';
        }

        $book = Book::where('google_book_id',$book_id)->first();

        // これまでレビュー登録があったかどうかの確認
        if($book === null){        
            // 過去にレビューされたことのない本の場合は、以下のページに飛ぶ。             
            return redirect()->route('books.nothingToShow',['book_id' => $book_id]);
        } else {
            $review = ReadingRecord::where('user_id', $user_id)->where('book_id', $book->id)->first();             
        }     
        // $others_reviews = ReadingRecord::where('book_id', $book->id)->whereNotIn('user_id', [$user_id])->whereNotIn('public_private', [0])->get();        
        $others_reviews = ReadingRecord::where('book_id', $book->id)->whereNotIn('user_id', [$user_id])->whereNotIn('public_private', [0])->get();        
        $review_count = ReadingRecord::where('book_id', $book->id)->count();           

        return view('books.show',[
            'items' => $items,
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

    public function nothingToShow($book_id){
        $items = null;
        
        //グーグルブックスの書籍情報取得
        if(isset($book_id)){
            $items[] = OpenBd::openBdIsbn($book_id);
            $message = null;
        }

        return view('books.nothing-to-show',['items'=>$items[0]]);
    }

    public function update(int $reading_record_id, ReadingRecordRequest $request)
    {
        $reading_record = ReadingRecord::find($reading_record_id);
        $reading_record->fill($request->all())->save();
        return redirect()->route('books.index');
    }

    public function destroy(int $reading_record_id){
        $reading_record = ReadingRecord::find($reading_record_id);
        $reading_record->delete();
        return redirect()->route('books.index');
    }

    public function like($reading_record_id, Request $request){

        $reading_record = ReadingRecord::find($reading_record_id);

        $reading_record->likes()->detach($request->user()->id);
        $reading_record->likes()->attach($request->user()->id);       

        return [
            'countLikes' => $reading_record->count_likes,
        ];

    }

    public function unlike($reading_record_id, Request $request){

        $reading_record = ReadingRecord::find($reading_record_id);

        $reading_record->likes()->detach($request->user()->id);        

        return [
            'countLikes' => $reading_record->count_likes,
        ];
    }
}
