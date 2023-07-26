<?php

namespace App\Http\Resources\API;

use App\Http\Resources\GlobalCollection;
use App\Models\Country;
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
        $countries = Country::whereIn('id', array_map('intval',$this['country_id']))->select('id','name','code')->get();
        $data =  [
            'id'=> $this->id,
            'name'=> $this->name,
            'branches_name'=> $this->branches_name??'...',
            'country_code'=> implode(',',$countries->pluck('code')->toArray()),
            'country_id'=> implode(',',$this->country_id),
            'country_name'=> implode(',',$countries->pluck('name')->toArray()),
            'total_campaigns'=> $this->campaigns()->count(),
            'total_branches'=> $this->branches()->count(),
            'status'=> $this->status,
            'create_date'=> $this->created_at,
			'image'=>$this->image
        ];
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
