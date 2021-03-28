<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

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
}
