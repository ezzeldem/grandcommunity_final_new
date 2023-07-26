<?php

namespace App\Http\Resources\API;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseStudiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'total_followers'=>$this->total_followers,
            'total_influencers'=>$this->total_influencers,
            'total_days'=>$this->total_days,
            'total_reals' =>$this->total_reals,
            'campaign_name' =>($this->campaign) ? $this->campaign->name : '',
            'description' =>$this->real,
			'image'=>  json_decode($this->image,true),
			'channels'=>$this->getChannels($this->channels),

        ];

    }

}
