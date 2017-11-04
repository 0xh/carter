<?php

namespace NickyWoolf\Launch\Http\Middleware;

use Closure;

class HasShopDomain
{
    public function handle($request, Closure $next)
    {
        if ($request->has('shop')) {
            return $next($request);
        }

        return redirect(route('launch.signup'));
    }
}