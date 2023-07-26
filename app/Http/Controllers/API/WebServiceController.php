<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\API\MainResource;
use App\Models\Subbrand;
use App\Models\Campaign;
use App\Http\Services\CampaignService;
use App\Http\Services\Eloquent\Campaign as CustomModel;



class WebServiceController extends Controller
{

    public function campaignConfirmation(Request $request){
		try{
			$campaignService = new CampaignService(new CustomModel());
			$data = $campaignService->updateInfluencerStatus($request);
				return response()->json($data);
		}catch (\Exception $exception){
			return  ['status' => false ,'message'=>'Server Error !!'];
		}
    }


}

