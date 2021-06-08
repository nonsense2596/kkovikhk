<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\YoungTeacher;
use App\Models\Vote;
use App\Models\YoungVote;
use Illuminate\Http\Request;

use Auth;

class VoteController extends Controller
{
    // TODO IMPLEMENT BACKEND CHECKS FOR THE FORM, IF NOT NULL!!!
    public function vote()
    {
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted();
        if($already_voted)
            abort(403,"Már szavaztál");

        $teachers = Teacher::all();
        return view('vote',compact('teachers'));
    }

    public function votepost(Request $request){
        $current_user = Auth::user();
        if($current_user->has_already_voted())
            abort(403,"Már szavaztál");

        $validated = $request->validate([
            'id' => 'required',
        ]);

        $vote = (int)$validated["id"];

        if(!Teacher::where('id',$vote)){
            return redirect("/vote");
        }

        $new_vote = new Vote([
            'user_id' => $current_user->id,
            'teacher_id' => $vote,
        ]);
        $new_vote->save();

        return redirect('/voteselect');
    }

    public function youngvote()
    {
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted_young();
        if($already_voted)
            abort(403,"Már szavaztál");

        $teachers = YoungTeacher::all();
        return view('youngvote',compact('teachers'));
    }

    public function youngvotepost(Request $request){
        $current_user = Auth::user();
        if($current_user->has_already_voted_young())
            abort(403,"Már szavaztál");

        $validated = $request->validate([
           'id' => 'required',
        ]);

        $vote = (int)$validated["id"];

        if(!YoungTeacher::where('id',$vote)){
            return redirect("/youngvote");
        }

        $new_vote = new YoungVote([
            'user_id' => $current_user->id,
            'teacher_id' => $vote,
        ]);
        $new_vote->save();

        return redirect('/');
    }
}
