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
    // todo gates to global function
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
    // todo inspect this shit
    public function addteacher()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $request = request();
        //dd($teacher->teachername);
        $teacher = new Teacher([
            'name' => $request->teachername,
            'description' => $request->teacherdescription,
        ]);
        $teacher->save();
        //return redirect('/admin');
    }
    public function modifyteacher()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $request = request();
        $current_teacher = Teacher::where('id',$request->teacherid)->firstorfail();
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
    // //////////////////////////////////////////////////////////////////////////////// //
    public function deleteteacheryoung()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $request = request('teacherid');
        $teacher = YoungTeacher::find($request);
        $teacher->delete();
    }
    // todo inspect this shit
    public function addteacheryoung()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $request = request();
        //dd($teacher->teachername);
        $teacher = new YoungTeacher([
            'name' => $request->teachername,
            'description' => $request->teacherdescription,
        ]);
        $teacher->save();
        //return redirect('/admin');
    }
    public function modifyteacheryoung()
    {
        if(!Gate::allows('admin')){
            abort(403);
        }
        $request = request();
        $current_teacher = YoungTeacher::where('id',$request->teacherid)->firstorfail();
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
}
