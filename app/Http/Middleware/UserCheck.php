<?php

namespace App\Http\Middleware;

use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class UserCheck
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		
		if (auth()->check()) {
			switch(auth()->user()->type){
				case "0":
					if(auth()->user()->brands()->exists() && auth()->user()->brands->status!=1)
					      return response()->json(['status' => false, 'user_inactive'=>true, 'message' =>'something went wrong contact support to check your data']);					
				break;
				case "1":
					if(auth()->user()->influencers()->exists() && auth()->user()->influencers->active!=1)
					     return response()->json(['status' => false,'user_inactive'=>true, 'message' =>'something went wrong contact support to check your data']);					
				break;
				default:
				break;   
					
			}
			 return $next($request);    
        }
    }
}
