<?php

namespace App\Http\Middleware;

use Closure;

class GoalBelongsObjective
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
        if($request->objective->hasGoal($goalId)){
          return $next($request);

        } else {
          abort(404, 'La meta no pertenece al objetivo');
        }
    }
}
