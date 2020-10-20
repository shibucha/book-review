<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        return view('contacts.index');
    }

    public function confirm(){
        return view('contacts.confirm');
    }

    public  function complete(){
        return redirect()->route('contacts.index',[
            "message" => "送信完了しました！",
        ]);
    }
}
