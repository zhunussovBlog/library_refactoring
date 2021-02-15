<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->user()) || !$request->user()->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
