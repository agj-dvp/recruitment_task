<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExpiryHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expiry = Carbon::tomorrow()->addMinutes(10)->toRfc7231String();
        $response = $next($request);
        $response->header('Expires', $expiry);
        return $response;
    }
}
