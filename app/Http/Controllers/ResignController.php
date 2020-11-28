<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
            $user_icon = basename($user_resign->icon);                    
            Storage::disk('s3')->delete('icons/' . $user_icon);
        }

        $user_resign->delete();

        return redirect()->route('index');
    }
}
