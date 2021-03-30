<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Teacher;
use App\Models\YoungTeacher;
use Illuminate\Support\Facades\Gate;

use Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function admin()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }

        $current_user = Auth::user();

        $teachers = Teacher::all();

        $teachers_young = YoungTeacher::all();

        return view("admin", compact('current_user','teachers','teachers_young'));
    }

    public function deleteteacher()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $faszom = request('teacherid');
        $teacher = Teacher::find($faszom);
        Log::debug($teacher);
        $teacher->delete();

        //Teacher::delete();
    }
}
