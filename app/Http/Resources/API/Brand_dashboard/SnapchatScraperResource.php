<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\LogSnapchat;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SnapchatScraperResource extends JsonResource
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
            'user_name' => (string) $this->snap_username,
            'name' => (string) $this->name,
            'image' => (string) $this->snap_image,
            'followers' => $this->followers,
            'uploads' => $this->uploads,
            'engagement_average_rate' => $this->engagement_average_rate,
            'is_verified' => (int) $this->is_verified,
            'is_private' => (int) $this->is_private,
            'bio' => (string) $this->bio,
            'top_posts' => ($this->snapmedias) ? $this->snapmedias : [],
            'charts' => LogSnapchat::select('created_at', 'followers', 'uploads')->where('snapchat_id', $this->id)->whereDate('created_at', '<=', $today)->whereDate('created_at', '>=', $eightMonthsAgo)->cursor()->map(function ($item) {
                return [
                    'created_at' => Carbon::Parse($item->created_at)->format("Y-m-d"),
                    'followers' => $item->followers,
                    'uploads' => $item->uploads,
                    'engagement_average_rate' => $item->engagement_average_rate,
                ];
            }),
        ];
    }
}
