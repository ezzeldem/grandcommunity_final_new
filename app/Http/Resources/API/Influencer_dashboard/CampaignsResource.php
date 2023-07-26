<?php

namespace App\Http\Resources\API\Influencer_dashboard;

use App\Http\Resources\GlobalCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignsResource extends JsonResource
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
            'campaign_id' => $this->campaign->camp_id ?? '',
            'campaign_name' => $this->campaign->name ?? '',
            'campaign_type' => $this->campaign->getType(),
            'campaign_status' => campaignStatusName($this->campaign->status),
            'influencer_code' => $this->influencer->code ?? '',
            'start_date' => $this->campaign->visit_start_date ?? '',
            'end_date' => $this->campaign->visit_end_date ?? '',
            'brand_name' => $this->campaign->brand->name ?? '',
            'duration' => ($this->campaign->visit_start_date ?? '') . ' to ' . ($this->campaign->visit_end_date ?? ''),
            'branch' => $this->branch->name ?? '',
            'brief' => $this->campaign->brief ?? '',
            'confirmation_date' => $this->confirmation_date ?? '',
            'confirmation_start_time' => $this->confirmation_start_time ?? '',
            'confirmation_end_time' => $this->confirmation_end_time ?? '',
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
