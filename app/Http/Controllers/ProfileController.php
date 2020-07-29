<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index(){
        return view('profiles.index');
    }

    public function store(ProfileRequest $request){

    }
}
