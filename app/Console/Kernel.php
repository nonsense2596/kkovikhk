<?php

namespace App\Console;

use App\Models\VotingPeriod;
use App\Models\YoungVote;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // TODO SETUP CRONTAB ON LIVE ENVIRONMENT
        $schedule->call(function(){
            DB::table('young_votes')->truncate();
        })->dailyAt('23:59')->when(function(){
            $votingperiod = VotingPeriod::getVotingPeriodOrInit();
            $current_date = date('Y-m-d');
            $current_date_plus = date('Y-m-d',strtotime('+1 days'));
            if($current_date<$votingperiod->start && $current_date_plus>=$votingperiod->start){
                return true;
            }
            else return false;
        });

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
