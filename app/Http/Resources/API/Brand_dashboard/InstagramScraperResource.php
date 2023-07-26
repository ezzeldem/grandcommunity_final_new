<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\LogInstagram;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InstagramScraperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $top_hashtags = [];
        if (!empty($this->details)) {
            $hashtagData = isset(json_decode($this->details)->top_hashtags) ? json_decode($this->details)->top_hashtags : [];
            foreach ($hashtagData as $item => $val) {
                $top_hashtags[] = $item;
            }
        }

        $top_mentions = [];
        if (!empty($this->details)) {
            $mentionsData = isset(json_decode($this->details)->top_mentions) ? json_decode($this->details)->top_mentions : [];
            foreach ($mentionsData as $item => $val) {
                $top_mentions[] = $item;
            }
        }

        $eightMonthsAgo = Carbon::Parse(now()->subMonths(8))->format("Y-m-d");
        $today = Carbon::Parse(now())->format("Y-m-d");

        return [
            'id' => (int) $this->id,
            'user_name' => (string) $this->insta_username,
            'name' => (string) $this->name,
            'image' => (string) $this->insta_image,
            'followers' => $this->followers,
            'following' => $this->following,
            'uploads' => $this->uploads,
            'engagement_average_rate' => $this->engagement_average_rate,
            'is_verified' => (int) $this->is_verified,
            'is_private' => (int) $this->is_private,
            'bio' => (string) $this->bio,
            "hastages" => $top_hashtags,
            "mentions" => $top_mentions,
            'top_posts' => ($this->instamedias) ? $this->instamedias()->select('id', 'shortcode', 'caption', 'media_type', 'likes', 'comments')->WhereJsonContains('post_reel_type', "0")->get() : [],
            'top_reels' => ($this->instamedias) ? $this->instamedias()->select('id', 'shortcode', 'caption', 'media_type', 'likes', 'comments')->WhereJsonContains('post_reel_type', "1")->get() : [],
            'charts' => LogInstagram::select('created_at', 'followers', 'following', 'uploads')->where('instagram_id', $this->id)->whereDate('created_at', '<=', $today)->whereDate('created_at', '>=', $eightMonthsAgo)->cursor()->map(function ($item) {
                return [
                    'created_at' => Carbon::Parse($item->created_at)->format("Y-m-d"),
                    'followers' => $item->followers,
                    'following' => $item->following,
                    'uploads' => $item->uploads,
                    'engagement_average_rate' => $item->engagement_average_rate,
                ];
            }),
        ];
    }
}
