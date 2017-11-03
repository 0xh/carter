<?php

namespace NickyWoolf\Thrust\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        if ($request->has('shop')) {
            return redirect()->route('thrust.login', $request->only('shop'));
        }

        return redirect()->route('thrust.expired-session');
    }
}