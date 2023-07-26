<?php

namespace App\Http\Resources\API;

use App\Models\Article;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

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
   
        $lang = $request->cookie('lang') ?? app()->getLocale();
        return [
            'lang' => app()->getLocale(),
            'id' => $this->id,
            'slug' => $this->slug,
            'sections' =>$this->sections->map(function ($section) use(&$lang){
                $data['id']              = $section['id'];
                $data['title']           = $section->getTranslation('title', $lang);
                $data['description']     = $section->getTranslation('description', $lang);
                return $data;
            }),
            'page_type'  => $this->page_type,
            'image'      => $this->image ?? '',
            'title'      => $this->getTranslation('title', $lang),
            'description'=> $this->getTranslation('description', $lang),
            'position'   => $this->position,
            'tags'       => explode(',', $this->getTranslation('tags', $lang)),
            'status'     => $this->status,
            'banner'     => getBannerImage(),
            'comments'   => $this->approved_comments,
            'user_image' => $this->admin()->image ?? '',
            'created_by' => $this->admin()->name ?? '',
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'related'    => Article::Related($this->id),
        ];
    }
}
