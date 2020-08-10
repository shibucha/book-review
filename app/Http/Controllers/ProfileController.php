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

        if (isset($request->icon)) {
            Storage::disk('local')->delete('public/icons/' . $user->icon); //画像の更新があったら、前の画像をストレージファイルから削除する。
            $user->icon = ''; //usersテーブルのアイコンを空にする。
            $path = $request->file('icon')->store('public/icons');
            $image = basename($path);
        } elseif (isset($user->icon) && empty($request->icon)) {
            $image = $user->icon;
        } else {
            $image = '';
        }

        $user->icon = $image;
        $user->save();

        return redirect()->route('books.index', ['user' => $user])->with('success', '新しい画像を設定しました。');
    }

    // プロフィール画像の削除（deleteメメソッドを使用したら、列ごと削除されてしまった為以下の方法をとる。）
    public function destroy(int $user_id)
    {
        $user = User::find($user_id);
        if (isset($user->icon)) {
            Storage::disk('local')->delete('public/icons/' . $user->icon);
            $user->icon = NULL;
            $user->save();
        }
        return redirect()->route('books.index');
    }
}
