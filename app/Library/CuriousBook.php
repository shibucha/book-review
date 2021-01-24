<?php

namespace App\Library;

// Model
use App\Models\Book;
use App\Models\Author;

// Facade
use App\Facades\RakutenBook;

class CuriousBook
{
    private $book;
    private $author;
    private $item;
    private $book_id;

    public function __construct($book_id)
    {
        $this->book_id = $book_id;
        $this->book = new Book();
        $this->author = new Author();
        $this->item = RakutenBook::rakutenBooksIsbn($this->book_id);
    }

    public function storeCuriousBook()
    {
        $this->bookStore($this->book_id);
    }

    public function bookStore($book_id)
    {
        $book = Book::where('book_id', $book_id)->first();
        if (!isset($book)) {
            $this->book->title =  $this->item[0]->Item->title ?? '不明';
            $this->book->book_id = $this->item[0]->Item->isbn ?? '不明-' . mt_rand(1, 10000);
            $this->book->author_id = $this->authorStore($this->item);           
            $this->book->image = $this->item[0]->Item->largeImageUrl ?? 'null';
            $this->book->description = $this->item[0]->Item->itemCaption ?? '概要なし';
            $this->book->save();
        } else {
            return;
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
