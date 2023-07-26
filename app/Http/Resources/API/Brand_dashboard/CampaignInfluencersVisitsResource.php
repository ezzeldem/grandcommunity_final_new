<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Http\Resources\API\SocialResource;
use App\Http\Resources\GlobalCollection;
use App\Models\Interest;
use App\Models\Nationality;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignInfluencersVisitsResource extends JsonResource
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
            'id'=> (int)$this->id,
            'image'=> $this->campaignInfluncer->influencer->image,
            'subtitle'=> ucfirst($this->campaignInfluncer->influencer->name).' checked in '.ucfirst($this->campaignInfluncer->campaign->name),
            'date'=> Carbon::parse($this->created_at)->format('d/m/Y'),
        ];
    }

}
