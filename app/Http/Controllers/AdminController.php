<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Gate;

use Auth;

class AdminController extends Controller
{
    public function admin()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $current_user = Auth::user();

        return view("admin");
    }
}
