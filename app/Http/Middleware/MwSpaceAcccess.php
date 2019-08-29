<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MwSpaceAcccess
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!in_array($request->ip(), config('app.allow_ip'))) {
            return abort(503, 'Private area. We will track your IP: ' . $request->ip());
        }

        return $next($request);
    }
}
