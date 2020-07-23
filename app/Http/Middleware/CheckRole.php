<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        if (!$request->user()->hasAnyRole($role)) {
            // var_dump($request->user()->hasAnyRole($role));
            // var_dump($role);
            // return redirect('home');
            abort(403, 'No autorizado');
        }

        return $next($request);
    }
}
