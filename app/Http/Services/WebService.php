<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Influencer;
use Carbon\Carbon;

class WebService {


    protected $service_url;
    public function __construct()
    {
        $this->service_url =  env('whatsapp_config_url')."/api/v1/transfer" ;
    }




	/***  */
	public function CreateOrUpdateCampaign(array $data){
       
		//dd($this->service_url);
		$campaignId = $data['camp_id'];
		$campaign = Campaign::where('id',$campaignId)->first(['id','camp_id','name','status','campaign_type','visit_start_date','visit_end_date','visit_from','visit_to','deliver_start_date','deliver_end_date','delivery_from','delivery_to','invitation','brief']);
		$invitation = !empty($campaign->invitation) ? $campaign->invitation : '';
		$brief = !empty($campaign->brief) ? $campaign->brief : '';
        $campaign_branches = ($campaign->branches) ? $campaign->branches()->pluck('branches.name')->toArray() : [];
        $influencer_names = Influencer::join('campaign_influencers', 'campaign_influencers.influencer_id', '=', 'influencers.id')->where('campaign_influencers.campaign_id',$campaign->id)->WithoutAppends()->pluck('influencers.vInflUuid')->toArray();
		$campaign_color = randColor();
        $visit_start_date =  ($campaign->visit_start_date) ? Carbon::parse($campaign->visit_start_date)->format("Y-m-d") : NULL;
		$visit_end_date =  ($campaign->visit_end_date) ? Carbon::parse($campaign->visit_end_date)->format("Y-m-d") : NULL;
		$deliver_start_date =  ($campaign->deliver_start_date) ? Carbon::parse($campaign->deliver_start_date)->format("Y-m-d") : NULL;
		$deliver_end_date =  ($campaign->deliver_end_date) ? Carbon::parse($campaign->deliver_end_date)->format("Y-m-d") : NULL;
		$visit_from =  ($campaign->visit_from) ? Carbon::parse($campaign->visit_from)->format("H:i") : NULL;
		$visit_to =  ($campaign->visit_to) ? Carbon::parse($campaign->visit_to)->format("H:i") : NULL;
		$delivery_from =  ($campaign->delivery_from) ? Carbon::parse($campaign->delivery_from)->format("H:i") : NULL;
		$delivery_to =  ($campaign->delivery_to) ? Carbon::parse($campaign->delivery_to)->format("H:i") : NULL;

		$campaignObj = (object)['name'=>$campaign->name,'campaign_type'=>$campaign->campaign_type,'color'=>$campaign_color, 
							'camp_id'=>$campaign->camp_id,
							'visit_date'=>[$visit_start_date,$visit_end_date],'visit_time'=>[$visit_from,$visit_to],
							'delivery_date'=>[$deliver_start_date,$deliver_end_date],'delivery_time'=>[$delivery_from,$delivery_to],
							'invitation'=>$invitation,'brief'=>$brief,
						    'branch_names'=>$campaign_branches,'influencer_names'=>$influencer_names,'status'=>$campaign->status,
						     'target'=> ($campaign->target)?:0 ,'daily_influencer'=>($campaign->influencer_per_day)?:0
							,'confirm_target'=>($campaign->daily_influencer)?:0 ,'confirm_daily'=>($campaign->daily_confirmation)?:0
						];
		
							switch($data['action_type']){
								case "create":
									$this->InitCurlResponse('create_campaign','POST',$campaignObj);
								break;
								case "update":
									$this->InitCurlResponse('update_campaign','POST',$campaignObj);
								break;
							}
							
	}


	public function deleteCampaign(array $data){
		$campaignId = $data['camp_id'];
		$campIdValue = Campaign::where('id',$campaignId)->withTrashed()->value('camp_id');
		$this->InitCurlResponse('delete_campaign','POST',["camp_id"=>$campIdValue]);
	}


    /**
     * init curl 
     * @param {array} [reqData]
     * @param {string} [url]
    */
    public function InitCurlResponse($endpoint , $type , $params = [] ){
        try{
            $headers = [ 'Content-Type: application/json'];
            $endpoint = $this->service_url .'/'.$endpoint;
                    $ch = curl_init();
                    if ($type == 'POST') {
                        curl_setopt( $ch, CURLOPT_URL, $endpoint );
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $params ) );
                        curl_setopt( $ch, CURLOPT_POST, 1 );
                    } elseif ($type =='GET' ) {
                        curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
                    }
        
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
                    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        
            $response = curl_exec( $ch );
            curl_close( $ch );
        //dd($response);
            return json_decode( $response, true );  
       }catch (Exception $e){
           return '';
       }         
    }

}