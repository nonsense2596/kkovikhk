<?php

namespace App\Http\Controllers\Authsch;

use App\Models\Authsch\AdMemberships;
use App\Models\Authsch\User;
use App\Models\Authsch\AttendedCourses;
use App\Models\Authsch\LinkedAccounts;
use App\Models\Authsch\StudentClubMemberships;
use App\Models\Authsch\Entrants;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller as Controller;

use Auth;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('authsch.user',compact('user'));
    }
}
