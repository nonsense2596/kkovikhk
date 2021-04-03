<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Models\Teacher;
use App\Models\YoungTeacher;
use Illuminate\Support\Facades\DB;
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

        $votecounts = $this->countvotes()->sortByDesc("count");

        $teachers = Teacher::all();

        $teachers_young = YoungTeacher::all();

        $votingperiod = VotingPeriod::getVotingPeriodOrInit();

        return view("admin", compact('current_user','teachers','teachers_young','votingperiod','votecounts'));
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
        $votingperiod = VotingPeriod::getVotingPeriod(); // select only first if exists
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
    public function endvotingperiod()
    {
        $votingperiod = VotingPeriod::getVotingPeriod();
        if($votingperiod)
            $votingperiod->delete();
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
    public function countvotes(){
        return DB::table('votes')
            ->join('teachers','votes.teacher_id','=','teachers.id')
            ->select('teachers.name as name',DB::raw("count(votes.teacher_id) as count"))
            ->groupBy('teachers.name')
            ->get();
    }
}
