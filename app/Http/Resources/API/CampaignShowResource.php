<?php

namespace App\Http\Resources\API;

use App\Http\Resources\GlobalCollection;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $coverage_channels = $this->influencer->coverage_channel;

        $coverage_channels_array = [];
        $all_channels = getCampaignCoverageChannels();
        if(!is_null($coverage_channels)){
            foreach ($coverage_channels as $coverage_channel) {
                foreach($all_channels as $channel){
                    if($channel->id == $coverage_channel){
                        $coverage_channels_array[] = ['id' => $channel->id, 'title' => $channel->title];
                    }
                }
            }
        }

        $data=[
            'iinfluencer_id'=>$this->influencer->id,
            'statustest' => @$this->status,
            'influencer_name' => @$this->influencer->name,
            'influencer_countries' => @$this->influencer->country,
            'influencer_image' => @$this->influencer->image,
            'followers' => $this->influencer->followers ?? 'No Snapchat',
            'engagement' => @$this->influencer->engagement ? '%' . $this->influencer->engagement : '%0',
            'status' => getInfluencerCampaignStatus($this->status),
            'confirm_date' => ($this->confirmation_date) ? Carbon::parse($this->confirmation_date)->format('Y-m-d') : 'No Confirmation',
            'branch' => $this->branch->name ?? 'No Branch',
            'coverage' => @$this->coverage == 0 ? 'Not Yet' : 'Has Coverage',
            'coverage_date' =>  ($this->coverage_date) ? Carbon::parse($this->coverage_date)->format('Y-m-d') : 'No Coverage',
            'complain' => [
                "status" => count($this->influencer_complain) > 0  ? ($this->influencer_complain->status == 0 ? 'Unsolved' : 'Solved') : '' ,
                "details" => count($this->influencer_complain) > 0  ? $this->influencer_complain->complain : '',
            ],
            'reason' => $this->reason ?? 'No reason for rejection',
            'brief'=> $this->brief,
            'rating' => $this->rate ?? 0,
            'visit_or_delivery_date' => ($this->visit_or_delivery_date) ? Carbon::parse($this->visit_or_delivery_date)->format('d/m/Y') : 'Not Yet',
            'created_at' => ($this->created_at) ? Carbon::parse($this->created_at)->format('d/m/Y') : 'No Date',
            'created_by' => ($this->created_by) ? Carbon::parse($this->created_by)->format('d/m/Y') : 'No One',
            'coverage_channels' => $coverage_channels_array,
        ];

        if(!is_null($this->influencer->insta_uname)){
            $data['channels']['instagram'] = [
                "username" => @$this->influencer->insta_uname ?? null,
                "count" => $this->influencer->instagram->followers ?? '0',
                "engagment" => $this->influencer->instagram->engagement_average_rate ?? '0'  .'%',
            ];
        }

        if(!is_null($this->influencer->facebook_uname)){
            $data['channels']['facebook'] = [
                "username" => @$this->influencer->facebook_uname ?? NULL,
                "count" => $this->influencer->facebook->followers ?? '0',
                "engagment" => $this->influencer->facebook->engagement_average_rate ?? '0'  .'%',
            ];
        }

        if(!is_null($this->influencer->snapchat_uname)){
            $data['channels']['snapchat'] = [
                "username" => @$this->influencer->snapchat_uname ?? NULL,
                "count" => $this->influencer->snapchat->followers ?? '0',
                "engagment" => $this->influencer->snapchat->engagement_average_rate ?? '0'  .'%',
            ];
        }

        if(!is_null($this->influencer->tiktok_uname)){
            $data['channels']['tiktok'] = [
                "username" => @$this->influencer->tiktok_uname ?? NULL,
                "count" => $this->influencer->tiktok->followers ?? '0',
                "engagment" => $this->influencer->tiktok->engagement_average_rate ?? '0'  .'%',
            ];
        }

        if(!is_null($this->influencer->twitter_uname)){
            $data['channels']['twitter'] = [
                "username" => @$this->influencer->twitter_uname ?? NULL,
                "count" => $this->influencer->twitter->followers ?? '0',
                "engagment" => $this->influencer->twitter->engagement_average_rate ?? '0'  .'%',
            ];
        }

        return $data;
    }

    public static function collection($resource){
        return tap(new GlobalCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }
}
