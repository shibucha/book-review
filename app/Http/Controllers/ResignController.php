<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ResignController extends Controller
{
    public function index(){      

        return view('settings.resign');
    }

    public function destroy(){
        $user_id = Auth::id();        
        $user_resign = User::find($user_id);        
       
        $user_resign->delete();

        return redirect()->route('index');
    }
}
