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
use Illuminate\Support\Facades\Mail;
use App\Models\Authsch\User;

use Auth;

use App\Models\VotingPeriod;

class AdminController extends Controller
{

    public function sendmail()
    {
        $mailsubject = request('mailsubject');
        $mailbody = request('mailbody');

        $users = User::where('reqmail', true)->get();
        // TODO vannak queuek is a laravelben, hasznalni kene
        foreach ($users as $user) {
            usleep(100000);
            Mail::to($user->mail)
                ->send(new CallToVote($mailsubject, $mailbody, $user->displayName, $user->mail, $user->unsub));
        }
    }

    public function admin()
    {
        $current_user = Auth::user();

        $votecounts = $this->countvotes()->sortByDesc("count");
        $votenum = Vote::count();

        $votecountsyoung = $this->countvotesyoung()->sortByDesc("count");
        $votenumyoung = YoungVote::count();

        $teachers = Teacher::all();

        $teachers_young = YoungTeacher::all();

        $votingperiod = VotingPeriod::getVotingPeriodOrInit();

        $uniquevotenum = $this->countunique();

        $numofdays = ((strtotime($votingperiod->end) - strtotime($votingperiod->start)) / (60 * 60 * 24)) + 1;

        $enddate = date('Y-m-d', strtotime($votingperiod->end . ' + 1 days'));
        $today = date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 days'));
        if ($enddate > $today) {
            $enddate = $today;
        }

        $period = new DatePeriod(
            new DateTime($votingperiod->start),
            new DateInterval('P1D'),
            new DateTime($enddate),
        );

        $vote_distribution = [];
        foreach ($period as $day_index => $day) {
            foreach ($teachers as $teacher_index => $teacher) {
                $datestring = date('Y-m-d', $day->getTimestamp());
                $count = Vote::where('created_at', 'like', '%' . $datestring . '%')->where('teacher_id', $teacher->id)->count();
                if ($day_index == 0)
                    $vote_distribution[$day_index][$teacher_index] = $count;
                else
                    $vote_distribution[$day_index][$teacher_index] = $vote_distribution[$day_index - 1][$teacher_index] + $count;
            }
        }


        $young_vote_distribution = [];
        foreach ($period as $day_index => $day) {
            foreach ($teachers_young as $teacher_index => $teacher) {
                $datestring = date('Y-m-d', $day->getTimestamp());
                $count = YoungVote::where('created_at', 'like', '%' . $datestring . '%')->where('teacher_id', $teacher->id)->count();
                if ($day_index == 0)
                    $young_vote_distribution[$day_index][$teacher_index] = $count;
                else
                    $young_vote_distribution[$day_index][$teacher_index] = $young_vote_distribution[$day_index - 1][$teacher_index] + $count;
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
            'vote_distribution',
            'young_vote_distribution',
        ));
    }

    public function setvotingperiod()
    {
        // if does not have any row, add one
        // else get one (there should be only one, ever)
        // and update it
        $startdate = request("startdate");
        $enddate = request("enddate");
        $votingperiod = VotingPeriod::getVotingPeriod(); // select only first if exists
        if ($votingperiod) {
            $votingperiod->start = $startdate;
            $votingperiod->end = $enddate;
        } else {
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
        if ($votingperiod)
            $votingperiod->delete();
    }

    public function deleteteacher()
    {
        $teacher_id = request('teacherid');
        Teacher::destroy($teacher_id);
    }
    // todo inspect this shit
    public function addteacher()
    {
        $request = request();
        $teacher = new Teacher([
            'name' => $request->teachername,
            'description' => $request->teacherdescription,
        ]);
        $teacher->save();
        //return redirect('/admin');
    }
    public function modifyteacher()
    {
        $request = request();
        $current_teacher = Teacher::find($request->teacherid);
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
    // //////////////////////////////////////////////////////////////////////////////// //
    public function deleteteacheryoung()
    {
        $teacher_id = request('teacherid');
        YoungTeacher::destroy($teacher_id);
    }
    // todo inspect this shit
    public function addteacheryoung()
    {
        $request = request();
        $teacher = new YoungTeacher([
            'name' => $request->teachername,
            'description' => $request->teacherdescription,
        ]);
        $teacher->save();
        //return redirect('/admin');
    }
    public function modifyteacheryoung()
    {
        $request = request();
        $current_teacher = YoungTeacher::find($request->teacherid);
        $current_teacher->name = $request->teachername;
        $current_teacher->description = $request->teacherdescription;
        $current_teacher->save();
    }
    public function countvotes()
    {
        return DB::table('votes')
            ->join('teachers', 'votes.teacher_id', '=', 'teachers.id')
            ->select('teachers.name as name', DB::raw("sum(votes.weight) as count"))
            ->groupBy('teachers.name')
            ->get();
    }
    public function countvotesyoung()
    {
        return DB::table('young_votes')
            ->join('young_teachers', 'young_votes.teacher_id', '=', 'young_teachers.id')
            ->select('young_teachers.name as name', DB::raw("count(young_votes.teacher_id) as count"))
            ->groupBy('young_teachers.name')
            ->get();
    }
    public function countunique()
    {
        $votes = Vote::select('user_id')->get();
        $youngvotes = YoungVote::select('user_id')->get();
        $cumultative = $votes->concat($youngvotes);

        return count(collect($cumultative)->unique('user_id')->all());
    }
    public function deletevotes()
    {
        Vote::truncate();
    }
    public function deletevotesyoung()
    {
        YoungVote::truncate();
    }
}
