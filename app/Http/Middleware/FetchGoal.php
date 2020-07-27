<?php

namespace App\Http\Middleware;

use Closure;
use App\Goal;

class FetchGoal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $goalId = $request->route()->parameter('goalId');
        $request->goal = Goal::findorfail($goalId);
        return $next($request);
    }
}