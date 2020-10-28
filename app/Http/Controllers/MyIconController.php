<?php

namespace App\Http\Controllers;

// Model
use App\User;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\MyIconRequest;

// Facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// Facades
use App\Facades\ImageProccesing;
use App\Facades\EnvironmentalConfirmation;

class MyIconController extends Controller
{
    public function index(int $user_id)
    {
        // もし、他の人のプロフィール画像をクリックしたら、マイページに戻るようにする。
        if ($user_id !== Auth::id()) {
            return redirect()->route('books.index');
        }

        $image_path = ImageProccesing::getIconImagePath();
       
        $user = User::find($user_id);
        
        return view('settings.icon', [
            'user' => $user,
            'icon_url' => $image_path['icon_url'],
        ]);
    }

    //プロフィール画像の登録処理
    public function store(MyIconRequest $request, int $user_id)
    {
        // もし、他の人のレビューを操作しようとしたら、マイページにリダイレクトさせる。
        if ($user_id !== Auth::id()) {
            return redirect()->route('books.index');
        }

        $user = User::find($user_id);
        $disk_name =  ImageProccesing::getImageStorage();
        $image_path = ImageProccesing::getIconImagePath();
        $disk = Storage::disk($disk_name);       

        if (isset($request->icon)) {

            if (basename($user->icon) !== "default.png") {
                $icon = basename($user->icon);
                $disk->delete($image_path['icon_path'] . '/' . $icon); //画像の更新があったら、前の画像をストレージファイルから削除する。
            }

            $user->icon = ''; //usersテーブルのアイコンを空にする。            
            $path = $disk->put($image_path['icon_path'], $request->file('icon'), 'public'); //開発環境でのファイルパス ※ローカルであればpublic/iconsに保存するということ。
            $image = Storage::disk($disk_name)->url($path); //ブラウザ上でのファイルパスを返す。ローカルならば、/storage/icons... AWSならば、URLがそのまま返ってくる。
        } elseif (isset($user->icon) && empty($request->icon)) {
            // 元々アイコンの設定はあるが、リクエストが空のまま設定ボタンを押した場合
            $image = $user->icon;
        } else {
            // 元々アイコン画像の設定されておらず、かつリクエストも空の場合
            $image = $image_path['icon_url'].'default.png';
        }

        $user->icon = $image;
        $user->save();

        return redirect()->route('books.index', ['user' => $user]);
    }

    // プロフィール画像の削除（deleteメメソッドを使用したら、列ごと削除されてしまった為以下の方法をとる。）
    public function destroy(int $user_id)
    {
        $user = User::find($user_id);
        $disk_name =  ImageProccesing::getImageStorage();
        $image_path = ImageProccesing::getIconImagePath();
        $disk = Storage::disk($disk_name);

        if (basename($user->icon) === 'default.png') {
            return redirect()->route('books.index');
        }

        if (isset($user->icon)) {
            $icon = basename($user->icon);
            $disk->delete($image_path['icon_path'] . '/' . $icon);   //book-reviewプロジェクトのローカルスロレージに保存するイメージパス
            $user->icon = $image_path['icon_url'] . 'default.png'; //view側で表示するためのイメージパス
            $user->save();
        }

        return redirect()->route('books.index');
    }
}
