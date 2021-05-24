<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkPassword
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
        if ($request->api_password != env("API_PASSWORD",'testpass')) {
            return response()->json(['message'=>'Unauthenticated.']);
        }
        return $next($request);
    }
}
