<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScannerConfirmedInfluenecrsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $coverage_channels = collect($this->influencer->coverage_channel)
            ->map(function ($channel) {
                $all_channels = getCampaignCoverageChannels();

                foreach ($all_channels as $channels) {
                    if ($channels->id == $channel) {
                        return ['title' => $channels->title];
                    }
                }
            })->toArray();

        $data = [
            'id' => $this->influencer->id,
            'user_name' => $this->influencer->name ?: $this->influencer->insta_uname,
            'image' => $this->influencer->instagram ? $this->influencer->instagram->insta_image : $this->influencer->image,
            'country' => $this->country_id ? $this->country->name : '',
            'coverage_channels' => $coverage_channels,
            'branch_name' => $this->branch_id ? $this->branch->name : '',
            'confirmation_date' => $this->confirmation_date ? Carbon::parse($this->confirmation_date)->format('d-m-Y') : '',
            'confirmation_start_time' => $this->confirmation_start_time ? Carbon::parse($this->confirmation_start_time)->format('H:i') : '',
            'confirmation_end_time' => $this->confirmation_end_time ? Carbon::parse($this->confirmation_end_time)->format('H:i') : '',
        ];

        return $data;
    }
}
