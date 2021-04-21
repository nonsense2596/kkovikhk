<?php

namespace App\Http\Controllers;

use App\Models\VotingPeriod;
use Illuminate\Http\Request;
use App\Models\User;    // talan nem kell
use App\Http\Controllers\Controller as Controller;

use Auth;

class IndexController extends Controller
{
    public function index()
    {
        $current_user = Auth::user();
        $isvotingperiod = VotingPeriod::isVotingPeriod();
        return view("index",compact('current_user','isvotingperiod'));
    }
    public function voteselect()
    {
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted();
        $already_voted_young = $current_user->has_already_voted_young();
        return view("voteselect", compact('already_voted','already_voted_young'));
    }
    public function deleteaccget()
    {
        return view("deleteacc");
    }
    public function deleteaccpost()
    {
        //
    }
}
