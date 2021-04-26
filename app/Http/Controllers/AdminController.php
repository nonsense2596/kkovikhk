<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use App\Mail\CallToVote;
use App\Models\Teacher;
use App\Models\YoungTeacher;
use App\Models\Vote;
use App\Models\YoungVote;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Models\Authsch\User;

use Auth;
use Illuminate\Support\Facades\Log;

use App\Models\VotingPeriod;

class AdminController extends Controller
{

    public function sendmail()
    {
        $mailsubject = request('mailsubject');
        $mailbody = request('mailbody');

        $users = User::where('reqmail',true)->get();
        // TODO vannak queuek is a laravelben, hasznalni kene
        foreach($users as $user){
            usleep(100000);
            Mail::to($user->mail)
                ->send(new CallToVote($mailsubject,$mailbody,$user->displayName,$user->mail,$user->unsub));
        }

    }

    // todo gates to global function
    public function admin()
    {
        /*if(!Gate::allows('admin')){
            abort(403);
        }*/
        // test date arithmetics
        //dd([date('Y-m-d'),date('Y-m-d',strtotime('+1 days'))]);

        // test date arithmetics
        $current_user = Auth::user();

        $votecounts = $this->countvotes()->sortByDesc("count");

        $votenum = Vote::count();

        $votecountsyoung = $this->countvotesyoung()->sortByDesc("count");
        $votenumyoung = YoungVote::count();

        $teachers = Teacher::all();

        $teachers_young = YoungTeacher::all();

        $votingperiod = VotingPeriod::getVotingPeriodOrInit();

        $uniquevotenum = $this->countunique();

        $numofdays = ((strtotime($votingperiod->end)-strtotime($votingperiod->start))/(60*60*24))+1;
        //ddd((strtotime($votingperiod->end)-strtotime($votingperiod->start)) / (60 * 60 * 24) +1);

        $period = new DatePeriod(
            new DateTime($votingperiod->start),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d',strtotime($votingperiod->end.' + 1 days'))),
        );
        $asd = null;
        foreach ($period as $key => $value) {
            foreach($teachers as $key2 => $teacher){
                $datestring = date('Y-m-d',$value->getTimestamp());
                $count = Vote::where('created_at','like', '%'.$datestring.'%')->where('teacher_id',$teacher->id)->count();//->count();
                if($key==0)
                    $asd[$key][$key2]=$count;
                else
                    $asd[$key][$key2]=$asd[$key-1][$key2]+$count;
            }
        }
        //ddd($asd);

        $asd2 = null;
        foreach ($period as $key => $value) {
            foreach($teachers_young as $key2 => $teacher){
                $datestring = date('Y-m-d',$value->getTimestamp());
                $count = YoungVote::where('created_at','like', '%'.$datestring.'%')->where('teacher_id',$teacher->id)->count();//->count();
                if($key==0)
                    $asd2[$key][$key2]=$count;
                else
                    $asd2[$key][$key2]=$asd2[$key-1][$key2]+$count;
            }
        }

        return view("admin", compact(
            'current_user',
            'teachers',
            'teachers_young',
            'votingperiod',
            'votecounts',
            'votecountsyoung',
            'votenum',
            'votenumyoung',
            'uniquevotenum',
            'numofdays',
            'asd',
            'asd2',
        ));
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
    public function countvotesyoung(){
        return DB::table('young_votes')
            ->join('young_teachers','young_votes.teacher_id','=','young_teachers.id')
            ->select('young_teachers.name as name',DB::raw("count(young_votes.teacher_id) as count"))
            ->groupBy('young_teachers.name')
            ->get();
    }
    public function countunique(){
        $votes = Vote::select('user_id')->get();
        $youngvotes = YoungVote::select('user_id')->get();
        $cumultative = $votes->concat($youngvotes);

        return count(collect($cumultative)->unique('user_id')->all());
    }
    public function deletevotes(){
        Vote::truncate();
    }
    public function deletevotesyoung(){
        YoungVote::truncate();
    }
}
