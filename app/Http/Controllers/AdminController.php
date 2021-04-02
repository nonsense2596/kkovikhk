<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Teacher;
use App\Models\YoungTeacher;
use Illuminate\Support\Facades\Gate;

use Auth;
use Illuminate\Support\Facades\Log;

use App\Models\VotingPeriod;

class AdminController extends Controller
{
    // todo gates to global function
    public function admin()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/

        $current_user = Auth::user();

        $teachers = Teacher::all();

        $teachers_young = YoungTeacher::all();

        $votingperiod = VotingPeriod::where('id','>=','0')->first();
        if(!$votingperiod) $votingperiod = new VotingPeriod();

        return view("admin", compact('current_user','teachers','teachers_young','votingperiod'));
    }

    public function setvotingperiod()
    {
       /* if(!Gate::allows('admin')){
            abort(403);
        }*/
        // if does not have any row, add one
        // else get one (there should be only one, ever)
        // and update it
        $startdate = request("startdate");
        $enddate = request("enddate");
        $votingperiod = VotingPeriod::where('id','>=','0')->first(); // select only first if exists
        if($votingperiod){
            $votingperiod->start = $startdate;
            $votingperiod->end = $enddate;
        }
        else{
            $votingperiod = new VotingPeriod(([
                'start' => $startdate,
                'end' => $enddate,
            ]));
        }
        $votingperiod->save();
    }

    public function deleteteacher()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
        $faszom = request('teacherid');
        $teacher = Teacher::find($faszom);
        Log::debug($teacher);
        $teacher->delete();

        //Teacher::delete();
    }
    // todo inspect this shit
    public function addteacher()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
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
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
        $request = request();
        $current_teacher = Teacher::where('id',$request->teacherid)->firstorfail();
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
    // //////////////////////////////////////////////////////////////////////////////// //
    public function deleteteacheryoung()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
        $request = request('teacherid');
        $teacher = YoungTeacher::find($request);
        $teacher->delete();
    }
    // todo inspect this shit
    public function addteacheryoung()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
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
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
        $request = request();
        $current_teacher = YoungTeacher::where('id',$request->teacherid)->firstorfail();
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
}
