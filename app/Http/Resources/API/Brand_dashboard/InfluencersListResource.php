<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Http\Resources\API\SocialResource;
use App\Http\Resources\GlobalCollection;
use App\Models\Interest;
use App\Models\Nationality;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencersListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth()->user();
        return [
            'id'=>(int)$this->id,
            'name'=>(string)$this->name,
            'image'=>(string)$this->image,
            'insta_uname'=>(string)$this->insta_uname,
            'tiktok_uname'=>(string)$this->tiktok_uname,
            'snapchat_uname'=>(string)$this->snapchat_uname,
            'facebook_uname'=>(string)$this->facebook_uname,
            'twitter_uname'=>(string)$this->twitter_uname,
            'country'=>(object)$this->country,
            'brand_fav'=>(boolean)$this->brands()->where('brands.id',@$user->brands->id)->exists(),
            'dislike'=>(boolean)$this->dislikes()->where('brand_id',@$user->brands->id)->exists(),
            'instagram'=>  (new SocialResource($this->instagram))??[],
            'tiktok'=> (new SocialResource($this->tiktok))?? [],
            'snapchat'=> (new SocialResource($this->snapchat))?? [],
            'facebook'=> (new SocialResource($this->facebook))?? [],
            'twitter'=> (new SocialResource($this->twitter))?? [],
            'interest'=>$this->interests->pluck('interest') ?? [],
            'groups'=> $this->groups,
            'gender'=>$this->gender ?? null,
            'nationality'=> $this->nationality ? Nationality::select('code')->where('id',$this->nationality)->first() : null,
        ];
    }

    public static function collection($resource){
        return tap(new GlobalCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

}
