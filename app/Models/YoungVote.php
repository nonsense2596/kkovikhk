<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoungVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
    ];
}
