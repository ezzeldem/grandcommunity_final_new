<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $admin = Admin::where("email",$request['email'])->first();
        if($admin && $admin->active == 0){
            return redirect(RouteServiceProvider::LOGIN);
        }
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if($request->headers->has('accept')  && $request->header('accept') == 'application/json'){
                    return response()->json(['status'=>false,'message'=>'can not access this route when you login']);
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
