<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;

class checkAuthPermission
{
    public $permession;
    public $url;
    public $routeName;
    public $currentUrl;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function __construct()
    {
        $this->currentUrl =   Route::current()->getName();
        $this->routeName = explode('.', $this->currentUrl);
        $this->url = $this->routeName[1];
    }

    public function changeName()
    {
        if ($this->url == 'influences') {
            $this->url = 'influencers';
            $this->url = str_replace("-", "_", $this->url);
        }
		
    }
    public function handle(Request $request, Closure $next)
    {
        
        $this->changeName();
        $fnName = Route::getCurrentRoute()->getActionMethod();
        $mainpage  = Route::getFacadeRoot()->current()->uri ;
        if(!$mainpage == 'dashboard')
        if ( $fnName == 'index' || $fnName == "edit" || $fnName == "create" || $fnName == "destroy" ) {
            
            $permissions =  auth()->user()->getAllPermissions()->pluck('name')->toArray();
            switch (Route::getCurrentRoute()->getActionMethod()) {
                case ('index'):
                    if (in_array('read ' . $this->url, $permissions))
                        $this->permession = true;
                    break;
                case ('create'):
                    if (in_array('create ' . $this->url, $permissions))
                        $this->permession = true;
                    break;
                case ('edit'):
                    if (in_array('update ' . $this->url, $permissions))
                        $this->permession = true;
                    break;
                    if (!in_array('delete ' . $this->url, $permissions))
                        $this->permession = true;
                    break;
                default:
            }
            if ($this->permession == true)
                return $next($request);
            else
                return redirect()->route('not_authrize');
        }
        return $next($request);
    }
}
