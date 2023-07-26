<?php

namespace App\Http\Resources\Admin;

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SubBrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $countries = Country::whereIn('id', array_map('intval', (array)$this['country_id']))->select('id','name','code')->get()->toArray();
        $all_social = [$this->link_insta,$this->link_facebook,$this->link_tiktok,$this->link_twitter,$this->link_snapchat,$this->link_website];

        $data =  [
            'id'=>$this->id,
            'name'=>$this->name,
            'preferred_gender'=>$this->preferred_gender,
            'image'=>$this->image,
            'brand_name'=>$this->brand_name,
            'brand_id'=>$this->brand_id,
            'country_id'=>$countries,
            'phone'=>$this->phone,
            'created_at'=>$this->created_at,
            'status'=>$this->status,
            'expirations_date' => $this->expirations_date,
            'branches' => @$this->branches ?? null,
            'whats_number'=>$this->whats_number,
            'social'=>$all_social,
            'active_data'=>['id'=>$this->id,'active'=>$this->status]
        ];
       return $data;
    }
}
