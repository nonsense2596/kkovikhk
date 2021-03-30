<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

use Auth;

class VoteController extends Controller
{
    public function vote()
    {
        $teachers = Teacher::all();
        return view('vote',compact('teachers'));
    }
    public function youngvote()
    {
        return 'vote young';
    }

    public function votepost(){
        $current_user = Auth::user();
        $already_voted = $current_user->has_already_voted();
        if($already_voted)
            abort(403,"already voted ya cake");
        $request = \request(['name']);
        $vote = $request["name"];
        $num_of_teachers = count(Teacher::all());

        if($vote<=0 || $vote>$num_of_teachers)
            return redirect('/vote');
        else
            return redirect('/');
    }
}
