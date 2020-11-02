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
        $data = RakutenBook::getTopPageContents();
        // foreach($data as $d){
        //     ddd($d->author->author); 
        // }
        // $data =null;       
        return view('home', ['data'=>$data]);
    }
}
