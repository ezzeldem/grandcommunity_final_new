<?php

namespace App\Http\Middleware;

use App\Http\Controllers\APIController;
use Closure;
use Illuminate\Http\Request;

class ChangeCountry
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
          $country = session()->get('country');
          //dd($country);

//        $request->attributes->add(['country' => 'myValue']);
        $request['country']=$country;
//        dd($request,$request->all(),gettype($request));

        return $next($request);
    }
}
