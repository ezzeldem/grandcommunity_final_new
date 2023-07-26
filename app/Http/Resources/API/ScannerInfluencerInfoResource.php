<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use App\Models\Campaign;
use App\Models\CampaignInfluencerVisit; 

class ScannerInfluencerInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $campaignInfluencer = $this->campaignInfluencer()->where('campaign_id',$request->camp_id)->first();
        $campaign = Campaign::find($request->camp_id);
        $campaignObject = CampaignInfluencerVisit::where('campaign_influencer_id',$campaignInfluencer->id)->where('incorrect',0)->orderBy('actual_date','desc');
        $campaignVisits = $campaignObject->first();
        $country_timezone = $request->country_timezone;
        $branches = $campaign->branches()->where('branches.country_id',$request->country_id)->get(['branches.id','branches.name']);

        $visits = [];
        $all_visits =  $campaignObject->get();
        $options = ['parts' => 1,'syntax' => CarbonInterface::DIFF_ABSOLUTE];
        foreach($all_visits as $single){
                $now = \Carbon\Carbon::now()->timezone($country_timezone);
                $from = \Carbon\Carbon::parse($single->actual_date)->timezone($country_timezone);
                $duration = $now->diffForHumans($from, $options);
            $visits[] =
                     [ 'v_d_date'=> Carbon::parse($single->actual_date)->format("Y-m-d"),
                       'v_d_time'=> Carbon::parse($single->actual_date)->format("H:i a"),
                       'branch_name'=>($single->branch) ? $single->branch->name :'' ,
                       'duration'=> $duration
                    ];
        }
        $data =  [
            'id'=> $this->id,
            'user_name' => ($this->name) ? $this->name : $this->insta_uname,
            'image' => ($this->instagram) ? $this->instagram->insta_image : $this->image,
            'last_visit_id'=>($campaignVisits) ? $campaignVisits->id  : 0,
            'v_d_date'=>($campaignVisits) ? Carbon::parse($campaignVisits->actual_date)->format("Y-m-d") : '',
            'v_d_time'=>($campaignVisits) ? Carbon::parse($campaignVisits->actual_date)->format("H:i a") : '',
            'no_of_guest'=>($campaignVisits) ? $campaignVisits->no_of_companions : 0 ,
            'branch_id'=>($campaignVisits && $campaignVisits->branch) ? $campaignVisits->branch->id : '',
            'branch_name'=>($campaignVisits && $campaignVisits->branch) ? $campaignVisits->branch->name : '',
            'allVisit'=>$visits,
            'branches'=>$branches,
            'camp_type'=>($campaign) ? $campaign->campaign_type : '',
        ];
        return $data;
    }
}
