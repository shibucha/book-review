<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{
    public function index(int $user_id){

        $user = User::find($user_id);
        return view('profiles.index',['user'=>$user]);
    }

    public function store(ProfileRequest $request, int $user_id){
        $user = User::find($user_id);

        if(isset($request->icon))
        {
            $path = $request->file('icon')->storeAs('public/icons', $user->id . '.png');
            $image = basename($path);
        }
        elseif(isset($user->icon) && empty($request->icon))
        {
            $image = $user->icon;
        }
        else
        {
            $image = '';
        }
        
        $form = [
            'image' => $image,
        ];
        

        $user->icon = $image;
        $user->save();
        
        return redirect()->route('books.index',['user'=>$user])->with('success', '新しい画像を設定しました。');
    }
}
