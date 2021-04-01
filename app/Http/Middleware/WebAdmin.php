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
        $user = session()->get('user');
        if (empty($user) || !$user->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
