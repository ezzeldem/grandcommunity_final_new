<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\CampaignSecret;
use App\Models\Country;

class ScannerAuthenticate
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

        if(!$request->hasHeader('scanner-token'))
               return response()->json(['status'=>false,'message'=>'un Authorized'], 401);


            $scanner_token = explode('|',$request->header('scanner-token'))[1];
            $camp_secret = CampaignSecret::where(['secret'=>$scanner_token,'is_active'=>1])->first();
			if(!$camp_secret || empty($camp_secret->campaignCountry->campaign_id))
                  return response()->json(['status'=>false,'message'=>'un Authorized'], 401);

            $campaign_id = $camp_secret->campaignCountry->campaign_id;
            $country_id = $camp_secret->campaignCountry->country_id;
            $country_timeZone = Country::where('id',$country_id)->first()->timezone;
              $request->merge(["camp_id" => $campaign_id ,"country_id"=>$country_id,'country_timeZone'=>$country_timeZone]);
            return $next($request);
     
    }
}
