<?php

namespace App\Http\Controllers;

use App\Models\VotingPeriod;
use App\Models\Authsch\User;
use App\Http\Controllers\Controller as Controller;

use Auth;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function index()
    {
        $current_user = Auth::user();
        $isvotingperiod = VotingPeriod::isVotingPeriod();
        $already_voted = $current_user != null ? $current_user->has_already_voted() : null;
        $already_voted_young = $current_user != null ? $current_user->has_already_voted_young() : null;
        return view("index",compact('current_user','isvotingperiod', 'already_voted','already_voted_young'));
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
        if($current_user->reqmail)
            $current_user->unsub = Str::uuid();

        $current_user->save();
    }
    public function unsubscribe($mail,$uuid)
    {
        $usertounsub = User::where([
            ['mail',$mail],
            ['unsub',$uuid]
        ])->first();

        if($usertounsub!=null){
            $usertounsub->reqmail=0;
            $usertounsub->unsub=null;
            $usertounsub->save();
            return "Successfully unsubscribed";
        }
        else return "There was a problem with your unsubscribe link.";
    }
}
