<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ComplainsResource extends JsonResource
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
            'id' =>['id'=>$this->id, 'campaign_id'=>$this->campaign_id],
            'complain' =>$this->complain,
            'campaign_name'=>['id'=> $this->campaign_id, 'name'=> optional($this->campaign)->name ] ,
            'influencer_name'=>optional($this->influencer)->name,
            'status'  => ['status'=>$this->status, 'campaign_id'=>$this->campaign_id,'id'=>$this->id],
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
        ];
    }
}
