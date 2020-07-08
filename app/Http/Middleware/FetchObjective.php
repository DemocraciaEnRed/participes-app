<?php

namespace App\Http\Middleware;

use Closure;
use App\Objective;

class FetchObjective
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
        $objId = $request->route()->parameter('objId');
        $request->objective = Objective::findorfail($objId);
        return $next($request);
    }
}
