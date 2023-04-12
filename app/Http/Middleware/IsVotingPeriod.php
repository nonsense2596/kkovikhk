<?php

namespace App\Http\Middleware;

use App\Models\VotingPeriod;
use Closure;
use Illuminate\Http\Request;

class IsVotingPeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(VotingPeriod::isVotingPeriod())
            return $next($request);
        abort(403,'Jelenleg nincs szavazási időszak');
        //else return redirect('/');
    }
}
