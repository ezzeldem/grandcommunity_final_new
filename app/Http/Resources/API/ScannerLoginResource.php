<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ScannerLoginResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $country = ($this->campaignCountry) ? $this->campaignCountry->country : '';
        $campaign = ($this->campaignCountry) ? $this->campaignCountry->campaign : '';
        $branches = [];
        if ($campaign && $country) {
            $branches = $campaign->branches()->where('branches.country_id', $country->id)->get(['branches.id', 'branches.name']);
        }

        if ($sercret_permissions = $this->permissions) {
            $sercret_permissions = $sercret_permissions->map(function ($per) {
                return ['id' => $per->id, 'name' => $per->name = str_replace(' ', '_', strtolower($per->name))];
            });
        }

        $data = [
            'token' => $this->id . '|' . $this->encrypt($this->secret),
            'country_id' => ($country) ? $country->id : 0,
            'campaign_id' => ($campaign) ? $campaign->id : 0,
            'campaign_name' => ($campaign) ? $campaign->name : '',
            'branches' => $branches,
            'permissions' => $sercret_permissions,
            "has_guest" => ($campaign) ? $campaign->has_guest : 0,
            "guest_numbers" => ($campaign) ? $campaign->guest_numbers : 0,
            "has_voucher" => ($campaign) ? $campaign->has_voucher : 0,
            'report_pdf' => ($campaign) ? $campaign->report_pdf : '',
        ];
        $data = $data;
        if ($data) {

        }

        return $data;
    }
}
