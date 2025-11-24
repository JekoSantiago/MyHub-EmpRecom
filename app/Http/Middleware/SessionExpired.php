<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class SessionExpired {

    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('Employee_ID')) {
            return redirect(route('logout'));
        }

        return $next($request);
    }
}
