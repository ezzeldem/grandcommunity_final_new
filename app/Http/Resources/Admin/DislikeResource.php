<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DislikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->influencer){
            return [
                'ids'=>[ 'brand_id' => $this->brand_id, 'influencer_id' => $this->influencer_id],
                'name' => $this->influencer->name,
                'country' => $this->influencer->country->name,   
            ];
        }
    }
}