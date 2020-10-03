<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyProfileController extends Controller
{
    public function index(){
        return view('settings.my-profile');
    }
}
