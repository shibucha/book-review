<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CuriousBook;

class CuriousBookController extends Controller
{
    public function index(){
        return view('curious-books.index');
    }

    // 読みたい本に追加
    public function update(){

    }

    // 読んだor読みたい本リストから削除
    public function delete(){

    }
}
