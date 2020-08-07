<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;

class BookController extends Controller
{
    public function index(){

        $user_id = Auth::id();
        $user = User::find($user_id);
        
        $is_icon = false;
        if(Storage::disk('local')->exists('public/icons/'. $user_id . '.jpg')){
            $is_icon = true;
        }
        
        return view('books.index', [
            'is_icon' => $is_icon,
            'user' => $user,
            ]);
    }

    public function create(){
        return view('books.create');
    }
}
