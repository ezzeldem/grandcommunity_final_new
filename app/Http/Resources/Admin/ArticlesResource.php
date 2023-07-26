<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ArticlesResource extends JsonResource
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
            'id' =>['id'=>$this->id, 'slug'=>$this->slug],
            'image' => $this->image,
            'title_en' =>  $this->getTranslation('title', 'ar'),
            'title_ar' =>  $this->getTranslation('title', 'en'),
//            'desc_en' =>  $this->getTranslation('description', 'en'),
//            'desc_ar' =>  $this->getTranslation('description', 'ar'),
            'status' => ['status'=>$this->status, 'id'=>$this->id],
            'created_by' => $this->admin()->first()->name ?? '__',
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y')
        ];
    }
}
