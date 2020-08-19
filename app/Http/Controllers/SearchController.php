<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Library\GoogleBook;
use App\Http\Requests\ReadingRecordRequest;
use App\ReadingRecord;
use App\Book;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        $items = null;
        $keyword = $request->keyword;

        if (!empty($keyword)) {
            //グーグルブックスの利用
            $items = GoogleBook::googleBooksKeyword($keyword);
        }
        return view('books.search', [
            'items' => $items,
            'keyword' => $keyword,
        ]);
    }

    public function store($book_id, ReadingRecordRequest $request, ReadingRecord $readingRecord, Book $book)
    {
        $items = null;

        if (isset($book_id)) {
            $items = GoogleBook::googleBooksKeyword($book_id);
        }

        $readingRecord->reading_date = $request->reading_date;
        $readingRecord->body = $request->body;
        $readingRecord->user_id = $request->user()->id;
        $readingRecord->save();

        return redirect()->route('books.index');
    }
}
