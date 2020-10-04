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
    public function index(){  
        $user = User::find(Auth::id());
        
        return view('settings.my-profile', ['user'=> $user]);
    }

    public function update(int $user_id, MyProfile $my_profile){

        $user_profile = $my_profile->where('user_id', $user_id)->first();
        ddd($user_profile);
        return redirect()->route('books.index');
    }
}
