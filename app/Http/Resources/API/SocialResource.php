<?php

namespace App\Http\Resources\API;

use App\Models\ScrapeFacebook;
use App\Models\ScrapeInstagram;
use App\Models\ScrapeSnapchat;
use App\Models\ScrapeTiktok;
use App\Models\ScrapeTwitter;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->resource instanceof ScrapeInstagram){
            return [
                'id' => (int)$this->id,
                'name' => (string)$this->name,
                'influe_brand_id' => (int)$this->influe_brand_id,
                'social_username' => (string)$this->insta_username,
                'social_id' => (string)$this->insta_id,
                'social_image' => (string)$this->insta_image,
                'followers' => (double)$this->followers,
                'following' => (double)$this->following,
                'uploads' => (double)$this->uploads,
                'engagement_average_rate' => (double)$this->engagement_average_rate,
                'bio' => (string)$this->bio,
                'total_likes' => (int)$this->total_likes,
                'total_comments' => (int)$this->total_comments,
                'last_check_date' => (string)$this->last_check_date,
            ];
        }elseif($this->resource instanceof ScrapeTiktok){
            return [
                'id' => (int)$this->id,
                'name' => (string)$this->name,
                'influe_brand_id' => (int)$this->influe_brand_id,
                'social_username' => (string)$this->tiktok_username,
                'social_id' => (string)$this->tiktok_id,
                'social_image' => (string)$this->tiktok_image,
                'followers' => (double)$this->followers,
                'following' => (double)$this->following,
                'uploads' => (double)$this->uploads,
                'engagement_average_rate' => (double)$this->engagement_average_rate,
                'bio' => (string)$this->bio,
                'total_likes' => (int)$this->total_likes,
                'total_comments' => (int)$this->total_comments,
                'last_check_date' => (string)$this->last_check_date,
            ];
        }elseif($this->resource instanceof ScrapeSnapchat){
            return [
                'id' => (int)$this->id,
                'name' => (string)$this->name,
                'influe_brand_id' => (int)$this->influe_brand_id,
                'social_username' => (string)$this->snap_username,
                'social_id' => (string)$this->snap_id,
                'social_image' => (string)$this->snap_image,
                'followers' => (double)$this->followers,
                'following' => (double)$this->following,
                'uploads' => (double)$this->uploads,
                'engagement_average_rate' => (double)$this->engagement_average_rate,
                'bio' => (string)$this->bio,
                'total_likes' => (int)$this->total_likes,
                'total_comments' => (int)$this->total_comments,
                'last_check_date' => (string)$this->last_check_date,
            ];
        }elseif($this->resource instanceof ScrapeFacebook){
            return [
                'id' => (int)$this->id,
                'name' => (string)$this->name,
                'influe_brand_id' => (int)$this->influe_brand_id,
                'social_username' => (string)$this->face_username,
                'social_id' => (string)$this->face_id,
                'social_image' => (string)$this->face_image,
                'followers' => (double)$this->followers,
                'following' => (double)$this->following,
                'uploads' => (double)$this->uploads,
                'engagement_average_rate' => (double)$this->engagement_average_rate,
                'bio' => (string)$this->bio,
                'total_likes' => (int)$this->total_likes,
                'total_comments' => (int)$this->total_comments,
                'last_check_date' => (string)$this->last_check_date,
            ];
        }elseif($this->resource instanceof ScrapeTwitter){
            return [
                'id' => (int)$this->id,
                'name' => (string)$this->name,
                'influe_brand_id' => (int)$this->influe_brand_id,
                'social_username' => (string)$this->twitter_username,
                'social_id' => (string)$this->twitter_id,
                'social_image' => (string)$this->twitter_image,
                'followers' => (double)$this->followers,
                'following' => (double)$this->following,
                'uploads' => (double)$this->uploads,
                'engagement_average_rate' => (double)$this->engagement_average_rate,
                'bio' => (string)$this->bio,
                'total_likes' => (int)$this->total_likes,
                'total_comments' => (int)$this->total_comments,
                'last_check_date' => (string)$this->last_check_date,
            ];
        }else{
            return  [];
        }




    }
}
