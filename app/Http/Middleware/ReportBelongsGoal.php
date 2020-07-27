<?php

namespace App\Http\Middleware;

use Closure;

class ReportBelongsGoal
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
        $reportId = $request->route()->parameter('reportId');
        if($request->goal->hasReport($reportId)){
          return $next($request);
        } else {
          abort(404, 'El reporte no pertenece a la meta');
        }
    }
}
