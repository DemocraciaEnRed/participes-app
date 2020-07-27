<?php

namespace App\Http\Middleware;

use Closure;
use App\Report;

class FetchReport
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
        $request->report = Report::findorfail($reportId);
        return $next($request);
    }
}