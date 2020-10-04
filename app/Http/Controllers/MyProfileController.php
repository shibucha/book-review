<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests\MyProfileRequest;
use App\MyFavorite;
use App\MyProfile;

class MyProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $my_profile = MyProfile::Where('user_id', $user->id)->first();
        $my_favorite = MyFavorite::Where('user_id', $user->id)->first();

        return view(
            'settings.my-profile',
            [
                'user' => $user,
                'my_profile' => $my_profile,
                'my_favorite' => $my_favorite,
            ]
        );
    }

    public function update(int $user_id, MyProfile $my_profile, MyProfileRequest $request, MyFavorite $my_favorite)
    {

        $user_profile = $my_profile->where('user_id', $user_id)->first();
        $user_favorite = $my_favorite->where('user_id', $user_id)->first();

        // ニックネームと自己紹介の登録
        if (!$user_profile) {
            $my_profile->user_id = $user_id;
            $my_profile->fill($request->all())->save();
        } else {
            $user_profile->fill($request->all())->save();
        }

        // お気に入り書籍の登録
        if (!$user_favorite) {
            $my_favorite->user_id = $user_id;
            $my_favorite->fill($request->all())->save();
        } else {
            $user_favorite->fill($request->all())->save();
        }

        return redirect()->route('settings.my_profile')->with('flash_message', 'プロフィールを更新しました！');
    }
}
