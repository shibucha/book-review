<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;

class ResignController extends Controller
{
    public function index(){      

        return view('settings.resign');
    }

    public function destroy(){
        $user_id = Auth::id();        
        $user_resign = User::find($user_id);

        // プロフィール画像をストレージから削除。
        if($user_resign->icon){
            Storage::disk('local')->delete('public/icons/' . $user_resign->icon);
        }

        $user_resign->delete();

        return redirect()->route('index');
    }
}
