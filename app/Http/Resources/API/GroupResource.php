<?php

namespace App\Http\Resources\API;

use App\Models\Country;
use App\Models\BrandFav;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        $favCount = $this->influencer_count;
//        if($favCount==0){
//            $countries= DB::table('group_lists')->where('id',$this['id'])->update(['country_id'=>[]]);
//        }

        $countriesNames = [];
        if(!empty($this->country_id)){
            $countriesNames = Country::whereIn('id', $this->country_id)->pluck('code')->toArray();
        }

        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'country_id'=> $countriesNames,
            'ids_country'=>is_array($this->country_id)?$this->country_id:[],
            'color'=>$this->color,
            'fav_count'=> $this->influencer_count,
            // "influencer_image"=>$image,
            "sub_brand_id"=>$this->sub_brand_id,
            "sub_brand_name"=>$this->sub_brands->name?? '__',
            "created_at"=>$this->created_at,
        ];
    }
}
