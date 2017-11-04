<?php

namespace NickyWoolf\Launch\Http\Middleware;

use Closure;

class HasValidHostname
{
    public function handle($request, Closure $next)
    {
        if ($this->validHostname($request->shop)) {
            return $next($request);
        }

        app()->abort(403, 'Client Error: 403');
    }

    protected function validHostname($shop)
    {
        return preg_match('/[a-z0-9]+\.myshopify\.com/', $shop);
    }
}