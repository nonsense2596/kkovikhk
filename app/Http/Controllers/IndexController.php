<?php

namespace App\Http\Controllers;

use App\Models\VotingPeriod;
use Illuminate\Http\Request;
use App\Models\Authsch\User;
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
        // do stuff
        $current_user = Auth::user();
        $dbuser = User::where('id',$current_user->id)->first();
        $dbuser->delete();

        return redirect('/')
            ->with('message','Fiók sikeresen törölve!');
    }
    public function reqmailchange()
    {
        $current_user = Auth::user();
        $current_user->reqmail = !$current_user->reqmail;
        $current_user->save();
    }
    public function unsubscribe($mail,$uuid)
    {
        
        //return $mail.$uuid;
        /*if(true){
            return "Successfully unsubscribed";
        }
        return "Error.";*/
    }
}
