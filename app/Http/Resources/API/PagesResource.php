<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;

class PagesResource extends JsonResource
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
            'lang' => app()->getLocale(),
            'id' => $this->id,
            'slug' => $this->slug,
            'sections' =>$this->sections->map(function ($section) {
                $data['id']              = $section['id'];
                $data['title']           = $section->getTranslation('title', app()->getLocale());
                $data['description']     = $section->getTranslation('description', app()->getLocale());
                return $data;
            }),
            'page_type' => $this->page_type,
            'image' => $this->image,
            'title' => $this->getTranslation('title', app()->getLocale()),
            'description' => $this->getTranslation('description', app()->getLocale()),
            'position' => $this->position,
            'status' => $this->status,
            'created_by' => $this->admin()->first()->name ?? '__',
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y')
        ];
    }
}
