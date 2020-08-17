<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Library\GoogleBook;

class SearchController extends Controller
{
    public function index(Request $request){

        $items = null;
        $keyword = $request->keyword;
    
        if(!empty($keyword)){
            //グーグルブックスの利用
            $items = GoogleBook::googleBooksKeyword($keyword);
        }
        return view('books.search',[
            'items' => $items,
            'keyword' => $keyword,
        ]);
    }

    public function store(){
        return redirect()->route('books.index');
    }
}
