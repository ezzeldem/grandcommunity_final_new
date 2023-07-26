<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class SetLanguage
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

        if(explode('/',\request()->path())[0]=='ar')
            app()->setLocale('ar');
        elseif(explode('/',\request()->path())[0]== "")
            (isset($_COOKIE['lang']) && $_COOKIE['lang'] == "ar") ? app()->setLocale('ar') : app()->setLocale('en');
        else
            app()->setLocale('en');

        return $next($request);
    }
}
