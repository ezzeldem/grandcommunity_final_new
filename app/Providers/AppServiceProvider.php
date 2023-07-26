<?php

namespace App\Providers;

use App\Models\Country;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cookie;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        $all_countries_data = Cache::remember('all_countries_data_v1', (60*72), function()
        {
            return Country::all();
        });

        $countries_active = Cache::remember('active_countries_data_v1', (60*72), function()
        {
            return Country::where('active','1')->get();
        });
        view()->share(compact('countries_active'));
        view()->share(compact('all_countries_data'));

        if(Cookie::get('lang')){
            app()->setLocale(Cookie::get('lang'));
        }

    }
}
