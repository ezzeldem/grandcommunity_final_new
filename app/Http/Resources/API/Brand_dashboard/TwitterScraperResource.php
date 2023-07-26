<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\LogTwitter;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TwitterScraperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $eightMonthsAgo = Carbon::Parse(now()->subMonths(8))->format("Y-m-d");
        $today = Carbon::Parse(now())->format("Y-m-d");

        return [
            'id' => (int) $this->id,
            'user_name' => (string) $this->twitter_username,
            'name' => (string) $this->name,
            'image' => (string) $this->twitter_image,
            'followers' => $this->followers,
            'following' => $this->following,
            'uploads' => $this->uploads,
            'engagement_average_rate' => $this->engagement_average_rate,
            'is_verified' => (int) $this->is_verified,
            'bio' => (string) $this->bio,
            "hastages" => [],
            'top_posts' => ($this->twittermedias) ? $this->twittermedias : [],
            'charts' => LogTwitter::select('created_at', 'followers', 'following', 'uploads')->where('twitter_id', $this->id)->whereDate('created_at', '<=', $today)->whereDate('created_at', '>=', $eightMonthsAgo)->cursor()->map(function ($item) {
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
