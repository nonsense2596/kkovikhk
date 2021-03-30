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
            abort(403,"already voted ya nugget");

        $teachers = Teacher::all();
        return view('vote',compact('teachers'));
    }

    public function votepost(){
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted();
        if($already_voted)
            abort(403,"already voted ya cake");

        $request = \request(['name']);
        $vote = $request["name"];
        $num_of_teachers = count(Teacher::all());

        if($vote<=0 || $vote>$num_of_teachers)  // fix to if id exists
            return redirect('/vote');

        $new_vote = new Vote([
            'user_id' => $current_user->id,
            'teacher_id' => $vote,
        ]);
        $new_vote->save();

        return redirect('/');
    }

    public function youngvote()
    {
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted_young();
        if($already_voted)
            abort(403,"already voted ya nugget");

        $teachers = YoungTeacher::all();
        return view('youngvote',compact('teachers'));
    }

    public function youngvotepost(){
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted_young();
        if($already_voted)
            abort(403,"already voted ya cakee");

        $request = \request(['name']);
        $vote = $request["name"];
        $num_of_teachers = count(YoungTeacher::all());

        if($vote<=0 || $vote>$num_of_teachers) // fix to if id exists
            return redirect('/vote');

        $new_vote = new YoungVote([
            'user_id' => $current_user->id,
            'teacher_id' => $vote,
        ]);
        $new_vote->save();

        return redirect('/');
    }
}
