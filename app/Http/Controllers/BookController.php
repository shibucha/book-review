<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){

        $is_icon = false;
        if(Storage::disk('local')->exitsts('public/icons/' . Auth::id() . '.jpg')){
            $is_icon = true;
        }
        return view('books.index', ['is_icon' => $is_icon]);
    }

    public function create(){
        return view('books.create');
    }
}
