<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\RakutenBook;

class HomeController extends Controller
{
   //トップページ の表示
    public function index(){
        // $data = RakutenBook::getTopPageContents();
        // ddd($data[0]);
        $data = null;
        return view('home', ['data'=>$data]);
    }
}
