<?php

namespace App\Http\Controllers\Authsch;

use App\Http\Controllers\Controller as Controller;

use Auth;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $ip = $_SERVER['REMOTE_ADDR'];

        return view('user',compact('user','ip'));
    }

}
