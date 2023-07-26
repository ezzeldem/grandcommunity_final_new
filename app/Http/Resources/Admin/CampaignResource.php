<?php

namespace App\Http\Resources\Admin;

use App\Http\Services\Eloquent\Campaign;
use App\Models\Brand;
use App\Models\CampaignInfluencerVisit;
use App\Models\Country;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class CampaignResource extends JsonResource
{
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $brand = Brand::select('name', 'id')->where('id', $this->brand_id)->first();
        $country_ids =  $this->campaignCountries()->pluck('country_id')->toArray();
        $countries = Country::whereIn('id', $country_ids)->get();
        $type=$this->campaign_type;
        $campaignType = Arr::where(campaignType(), function ($value, $key) use($type) { return ($key == $type) ? $value : '';});
        $camp_status = Status::where('value' ,(int)$this->status)->where('type', 'campaign')->first() ?? '';
        $start_date = (!empty($campaignType)) ? (array_values($campaignType)[0] == 'Visit') ? $this->visit_start_date : ((array_values($campaignType)[0] == 'Delivery') ?  $this->deliver_start_date :['visit'=>$this->visit_start_date, 'delivery'=>$this->deliver_start_date]):'';
        $end_date =  (!empty($campaignType)) ? (array_values($campaignType)[0] == 'Visit') ? $this->visit_end_date :((array_values($campaignType)[0] == 'Delivery') ?  $this->deliver_end_date :['visit'=>$this->visit_end_date, 'delivery'=>$this->deliver_end_date]):'';
//        $attendees = CampaignInfluencerVisit::whereHas('campaignInfluncer', function ($q){
//            $q->where('campaign_id', $this->id);
//        })->count();
        $secrets = $this?->secrets()->get()??'no secrets';

        return [
            'id' => $this->id,
            'camp_id' =>['id'=> $this->id,'status'=>$camp_status],
            'name' => $this->name,
            'brand' => @$brand->name??'not found',
            'start_date' => $start_date,
            'end_date' => $end_date,
            'countries' => $countries,
            'type' => (!empty($campaignType)) ? array_values($campaignType)[0]:'',
            'status' => $camp_status ,
            'avtice_status' => $camp_status ,
            'created_at' => Carbon::parse($this->created_at)->format('y-m-d H:i:s'),
            'influencer_per_day' => $this->influencer_per_day,
//            'attendees' => $attendees,
            'secrets' => $secrets,
//            'count_all' => $this->campaignInfluencers()->where('status',0)->count(),
//            'count_confirmation' => $this->campaignInfluencers()->where('status',1)->count(),
//            'count_visit' => $this->campaignInfluencers()->where('status',2)->count(),
//            'count_not_visit' => $this->campaignInfluencers()->where('status',3)->count(),
//            'count_cancel' => $this->campaignInfluencers()->where('status',4)->count(),
//            'count_waiting' => $this->campaignInfluencers()->where('status',5)->count(),
//            'count_incorrect' => $this->campaignInfluencers()->where('status',6)->count(),
            'reason' => $this->reason,
            'request_to_cancle' => $this->request_to_cancle,
        ];


    }
}
