<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotingPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
    ];

    public static function isVotingPeriod()
    {
        $votingperiod = VotingPeriod::getVotingPeriodOrInit();
        $current_date = date('Y-m-d');
        if ($current_date >= $votingperiod->start && $current_date <= $votingperiod->end)
            return true;
        else return false;
    }

    public static function getVotingPeriod()
    {
        return VotingPeriod::where('id', '>=', 0)->first();
    }

    public static function getVotingPeriodOrInit()
    {
        $votingperiod = VotingPeriod::getVotingPeriod();
        if (!$votingperiod) $votingperiod = new VotingPeriod();
        return $votingperiod;
    }
}
