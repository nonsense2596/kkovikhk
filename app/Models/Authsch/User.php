<?php

namespace App\Models\Authsch;

//use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Vote;
use App\Models\YoungVote;

class User extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'displayName',
        'mail',
        'bmeunitscope',
        'reqmail',
        'unsub',
    ];

    public function has_already_voted()
    {
        return $this->hasMany(Vote::class)->count() > 0;
    }
    public function has_already_voted_young()
    {
        return $this->hasMany(YoungVote::class)->count() > 0;
    }
}
