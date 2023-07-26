<?php

namespace App\Http\Resources\Admin;

use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseStudies extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $camp = Campaign::whereId($this->campaign_name)->first();
        return [
            'id'=>$this->id,
            'total_followers'=>$this->total_followers,
            'total_influencers'=>$this->total_influencers,
            'campaign_name'=>$this->campaign_name??'--',
            'total_days' =>$this->total_days,
            'real' => @((array)json_decode($this->real))[app()->getLocale()],
            'client_profile_link' =>$this->client_profile_link,
        ];

    }

}
