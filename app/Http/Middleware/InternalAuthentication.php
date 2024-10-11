<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InternalAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = $request->session()->get('secret') ?? $request->query('secret');

        if (config('swf.auth.enabled') && $secret !== config('swf.auth.secret')) {
            abort(401);
        }

        return $next($request);
    }
}
