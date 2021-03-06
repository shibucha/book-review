<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Model
use App\Models\Book;
use App\Models\Author;

// Facade
use App\Facades\RakutenBook;
use Illuminate\Support\Facades\Auth;

class CuriousBook extends Model
{
    private $curiousBooks = [];
    private $book;
    private $author;
    private $item;
    private $book_isbn;

    // public function __construct($book_isbn)
    // {
    //     $this->book_isbn = $book_isbn;
    //     $this->book = new Book();
    //     $this->author = new Author();
    //     $this->item = RakutenBook::rakutenBooksIsbn($this->book_isbn);
    // }


    // **************リレーション************************//
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo('App\Models\Book');
    }


    // **************その他************************//

    public function getCuriousBook()
    {
        if (Auth::user()) {
            return $this->with(['user', 'book'])->where('user_id', Auth::user()->id)->get();
        }
    }

    public function existenceCheckOfCurious($book_id)
    {
        if (Auth::user()) {
            return $this->with(['user', 'book'])->where('user_id', Auth::user()->id)->where('book_id', $book_id)->first();
        }
    }

    public function countCheckCuriousBooks($curious_books)
    {
        if (count($curious_books) > 0) {
            foreach ($curious_books as $book) {
                $curious_isbn[] = $book->book()->value('book_id');
            }
            return $curious_isbn;
        } else {
            return $curious_isbn[] = '';
        }
    }

    public function pushCuriousBtn($record, $book_id)
    {
        if (isset($record)) {
            $record->delete();
        } else {
            $this->user_id = Auth::user()->id;
            $this->book_id = $book_id;
            $this->save();
        }
    }
    
    public function enableCuriousBtn($user_id){
        if ($user_id) {
            $curious_books = $this->getCuriousBook();
            return $curious_isbn = $this->countCheckCuriousBooks($curious_books);
        } else {
            return $curious_isbn[] = '';
        }
    }


    public function checkLoginUser($user_id){
        if(Auth::user()->id !== $user_id){
            return redirect()->route('curious.index',['user_id'=>Auth::user()->id]);
        }       
    }
    public function storeCuriousBook()
    {
        return $book_id = $this->bookStore($this->book_isbn);
    }

    public function bookStore($book_isbn)
    {
        $book = Book::where('book_id', $book_isbn)->first();
        if (!isset($book)) {
            $this->book->title =  $this->item[0]->Item->title ?? '不明';
            $this->book->book_id = $this->item[0]->Item->isbn ?? '不明-' . mt_rand(1, 10000);
            $this->book->author_id = $this->authorStore($this->item);
            $this->book->image = $this->item[0]->Item->largeImageUrl ?? 'null';
            $this->book->description = $this->item[0]->Item->itemCaption ?? '概要なし';
            $this->book->save();
            return $this->book->id;
        } else {
            return $book->id;
        }
    }

    public function authorStore($item)
    {

        $author_name = $item[0]->Item->author;

        //もし含まれていないのなら’不明’
        if (!isset($item[0]->Item->author)) {
            $author_name = '不明';
        }

        //不明の場合、データベースに既に不明が存在しているかチェック
        if ($author_name === '不明') {
            $author = Author::where('author', '不明')->first();
        }

        //存在しているのならば、不明のidを$this->book->book_idに挿入
        if (isset($author)) {
            $author_id = $author->id;
        }

        //含まれているのならば、データベースに既に著者名が存在しているか確認
        if (isset($item[0]->Item->author)) {
            $author = Author::where('author', $item[0]->Item->author)->first();
        }

        //含まれていないのならば、新規登録およびそのidを$this->book->book_idに挿入
        if (isset($author)) {
            $author_id = $author->id;
        }

        if (!isset($author)) {
            $this->author->author = $item[0]->Item->author;
            $this->author->save();
            $author_id = $this->author->id;
        }

        //含まれているのならば、既に登録されているidを$this->book->book_idに挿入
        return $author_id;
    }
}
