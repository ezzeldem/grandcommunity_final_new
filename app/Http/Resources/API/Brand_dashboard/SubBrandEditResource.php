<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class SubBrandEditResource extends JsonResource
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
            'id'=> $this->id,
            'name'=> $this->name,
            'country'=> @$this->countries,
			'country_id'=>@$this->country_id,
            'branch_ids'=> @$this->branches->pluck('id')->toArray(),
            // 'branchs'=> @$this->branches()->get(['id','name','city','state','country_id'])->toArray(),
            'branchs'=> @$this->branches()->get(['id','name','city','state','country_id'])->map(function($branch){
                return [
                    'id'=> $branch->id,
                    'name'=> $branch->name,
                    'city'=> @$branch->cities->name,
                    'state'=> @$branch->states->name,
                    'country'=> @$branch->country->name,
                    'created_at'=> $this->created_at,
                    'status'=> $this->status,
                ];
            }),
            'preferred_gender'=> $this->preferred_gender,
            'image'=> $this->image,
            'whats_number'=> $this->whats_number,
            'phone'=> $this->phone,
            'brand_social_media'=> @$this->brand_social_media,
			'country_code_whats'=> PhoneCountryCode($this->code_whats),
            'country_code_phone'=> PhoneCountryCode($this->code_phone),
            'code_whats'=> $this->code_whats,
            'code_phone'=> $this->code_phone,
            'status'=> SubbrandStatus()[$this->status],
            'status_id'=> $this->status,
			'link_insta'=>$this->link_insta,
			'link_snapchat'=>$this->link_snapchat,
			'link_tiktok'=>$this->link_tiktok,
			'link_twitter'=>$this->link_twitter,
			'link_facebook'=>$this->link_facebook,
			'whatsapp_same_phone'=>( $this->phone == $this->whats_number && $this->code_whats == $this->code_phone) ? true :false,
            'link_website'=>$this->link_website,
        ];
    }
}
