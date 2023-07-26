<?php

namespace App\Http\Resources\API;

use App\Http\Resources\GlobalCollection;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ScannerReportResource extends JsonResource
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
        $campaignVisits = $campaignInfluencer->CampaignInfluencerVisit()->where('incorrect',0)->orderBy('actual_date','desc')->first();
        $data=[
            'id' => $this->id,
            'image' => ($this->instagram) ? $this->instagram->insta_image : $this->image,
            'user_name' => ($this->name) ? $this->name : $this->insta_uname,
            'camp_influ_id'=>($campaignInfluencer) ? $campaignInfluencer->id : 0, 
            'influencer_rate'=>($campaignInfluencer) ? $campaignInfluencer->rate : 0,
            'comment_rate'=>($campaignInfluencer) ? (string)$campaignInfluencer->comment_rate : '',
            'social_media'=>$this->SocialMedia(), 
            'v_d_date'=>($campaignVisits) ? Carbon::parse($campaignVisits->actual_date)->format("Y-m-d") : '',
            'v_d_time'=>($campaignVisits) ? Carbon::parse($campaignVisits->actual_date)->format("H:i a") : '',
            'no_of_guest'=>($campaignVisits) ? $campaignVisits->no_of_companions : 0 ,
            'branch'=>($campaignVisits && $campaignVisits->branch) ? $campaignVisits->branch->name : ''
        ];

        return $data;
    }
    
}
