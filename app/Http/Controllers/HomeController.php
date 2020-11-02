<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\RakutenBook;

// Model
use App\Book;
use App\Author;

class HomeController extends Controller
{
   //トップページ の表示
    public function index(){
        // トップページのコンテンツを取得する。
        $data = RakutenBook::getTopPageContents();              
        return view('home', ['data'=>$data]);
    }
}
