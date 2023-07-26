<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class CompleteDateResource extends JsonResource
{
    public $data;
    public function __construct($data)
    {
       $this->data = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
     
        $user=auth()->user();
        
        return [

            'user'=>[
                //'data' => $this->data,
                'name'=>$user->brands->name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'code'=>$user->code,
                'username'=>$user->user_name,
                'whatsapp_code'=>$user->brands->whatsapp_code,
                'whatsapp'=>$user->brands->whatsapp,
                'insta_uname'=>$user->brands->insta_uname,
                'facebook_uname'=>$user->brands->facebook_uname,
                'tiktok_uname'=>$user->brands->tiktok_uname,
                'snapchat_uname'=>$user->brands->snapchat_uname,
                'twitter_uname'=>$user->brands->twitter_uname,
                'website_uname'=>$user->brands->website_uname,
                'country_id'=>$user->brands->country_id,
                'image'=>$user->brands->image,
                'step'=>$user->brands->step,
                // 'step_name'=> ($user->brands->step == 1) ? 'basic information' : ( $user->brands->step == 2 ) ? 'subbrands' : 'step3',
        
            ],
        'group_of_brand' => $user->brands->subbrands()->firstOrFail() ?? [],
        'branches'=>$user->brands->branchs??[],
        ];
    }
}
