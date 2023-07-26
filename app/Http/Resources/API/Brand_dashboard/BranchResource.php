<?php

namespace App\Http\Resources\API\Brand_dashboard;
use App\Http\Resources\GlobalCollection;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       
        
        //$country = Country::where('id',intval($this->country_id))->first();

        $data =  [
            'id'=>$this->id,
            'name'=>$this->name,
            'address'=>$this->address??'',
            'lat'=>$this->lat??'',
            'lng'=>$this->lng??'',
            'brand_name'=>@$this->brand->name??(isset($this->subbrand)?$this->subbrand->brand_name:'..'),
            'brand_id'=>@$this->brand->id??(isset($this->subbrand)?@$this->subbrand->brand->id:'..'),
         //   'sub_brands' => ($this->brand->subbrands)??'..',
            'sub_brand_name'=>@$this->subbrand->name??'..',
            'sub_brand_id'=>@$this->subbrand->id??null,
            'city'=>$this->cities->name??'..',
            'city_id'=>@$this->city??'..',
            'created_at'=>$this->created_at,
            'country_id'=>@$this->country_id?? 0,
            'country'=>@$this->country->name,
            'country_code'=>@$this->country->code,
            'state'=>@$this->states->name??'..',
            'state_id'=>@$this->state??'..',
          //  'state_array'=> @$this->country->states->pluck('name','id') ??'..',
          //  'city_array'=> (isset($this->states->cities))?$this->states->cities->pluck('name','id') ??'..':'',
            'status'=>$this->status,
           // 'active_data'=>['id'=>$this->id,'active'=>$this->status]
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
