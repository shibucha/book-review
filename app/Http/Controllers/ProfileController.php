<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class ProfileController extends Controller
{
    public function index(int $user_id)
    {
        $user = User::find($user_id);
        return view('profiles.index', ['user' => $user]);
    }

    //プロフィール画像の登録処理
    public function store(ProfileRequest $request, int $user_id)
    {        
        $user = User::find($user_id);        
        $disk = Storage::disk('s3');  
        
        if (isset($request->icon)) { 

            if(basename($user->icon) !== "default.png"){
                $icon = basename($user->icon);                
                $disk->delete('icons/' . $icon); //画像の更新があったら、前の画像をストレージファイルから削除する。
            } 

            $user->icon = ''; //usersテーブルのアイコンを空にする。            
            $path = $disk->put('icons', $request->file('icon'), 'public');
            $image = Storage::disk('s3')->url($path);
                     
        } elseif (isset($user->icon) && empty($request->icon)) {
            $image = $user->icon;
        } else {
            $image = 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png';
        }

        $user->icon = $image;
        $user->save();

        return redirect()->route('books.index', ['user' => $user])->with('success', '新しい画像を設定しました。');
    }

    // プロフィール画像の削除（deleteメメソッドを使用したら、列ごと削除されてしまった為以下の方法をとる。）
    public function destroy(int $user_id)
    {
        $user = User::find($user_id);
        $disk = Storage::disk('s3');
        if (isset($user->icon)) {
            $icon = basename($user->icon);
            $disk->delete('icons/' . $icon);
            $user->icon = 'https://book-review-shibucha.s3.ap-northeast-1.amazonaws.com/icons/default.png';
            $user->save();
        }
        return redirect()->route('books.index');
    }
}
