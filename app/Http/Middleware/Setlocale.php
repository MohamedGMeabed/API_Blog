<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Setlocale
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
        $locale = $request ->header('x-language');
        // if(!in_array($locale,['ar','en'])){
        //     app()->setlocale('en');
        // }
        app()->setlocale($locale);

        return $next($request);
    }
}
