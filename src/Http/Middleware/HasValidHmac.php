<?php

namespace NickyWoolf\Carter\Http\Middleware;

use Closure;
use NickyWoolf\Shopify\Request;

class HasValidHmac
{
    protected $hmac;

    public function __construct(Request $hmac)
    {
        $this->hmac = $hmac;
    }
    public function handle($request, Closure $next)
    {
        if ($this->hmac->verify($request->all())) {
            return $next($request);
        }

        app()->abort(403, 'Client Error: 403');
    }
}