<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)

        // header('Access-Control-Allow-Origin:  *');
        // header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Authorization, Origin');
        // header('Access-Control-Allow-Methods:  POST, PUT, GET');
        // ->header('Access-Control-Allow-Origin', '*')
        // ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, DELETE, OPTIONS')
        // ->header('Access-Control-Allow-Headers','Accept, Authorization, Content-Type')
        ;
    }
}
