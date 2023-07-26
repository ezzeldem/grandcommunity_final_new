<?php

namespace App\Http\Resources\API;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'company_name'=>(app()->getLocale() == "ar") ? $this->company_name_ar : $this->company_name,
            'slogan'=>(app()->getLocale() == "ar") ? $this->slogan_ar : $this->slogan,
			'logo'=>$this->logo,
            

        ];

    }

}
