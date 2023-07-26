<?php

namespace App\Http\Resources\API;

use App\Http\Resources\GlobalCollection;
use App\Models\CampaignInfluencer;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \JsonSerializable
     */
    public function toArray($request)
    {
        $visits = CampaignInfluencer::where(['campaign_id' => $this->id, 'status' => 2])->count();
        $camp_status = Status::where('value', (int) $this->status)->where('type', 'campaign')->get();
        // $type=$this->campaign_type;
        // $campaignType = Arr::where(campaignType(), function ($value, $key) use($type) { return ($key == $type) ? $value : '';});
        $campaignType = [];
        if (!is_null($this->campaign_type)) {
            $type = $this->campaign_type;
            $campaignType = Arr::where(campaignType(), function ($value, $key) use ($type) {
                return ($key == $type) ? $value : '';
            });
        }
        if ($request->route()->getName() == 'api.v1.statistics') {

            $start_date = (!empty($campaignType)) ? (array_keys($campaignType)[0] == '0') ? $this->visit_start_date : ((array_keys($campaignType)[0] == '1') ? Carbon::parse($this->deliver_start_date)->format('Y-m-d') : ['visit' => Carbon::parse($this->visit_start_date)->format('Y-m-d'), 'delivery' => $this->deliver_start_date]) : '';
            $end_date = (!empty($campaignType)) ? (array_keys($campaignType)[0] == '0') ? $this->visit_end_date : ((array_keys($campaignType)[0] == '1') ? Carbon::parse($this->deliver_end_date)->format('Y-m-d') : ['visit' => Carbon::parse($this->visit_end_date)->format('Y-m-d'), 'delivery' => $this->deliver_end_date]) : '';
            $countries = $this->campaignCountries()->get()->map(function ($q) {
                $country = $q->country()->first();
                return ['id' => $country->id, 'image' => 'https://hatscripts.github.io/circle-flags/flags/' . Str::lower($country->code) . '.svg', 'code' => $country->code];
            });
        } else {
            $start_date = (!empty($campaignType)) ? (array_keys($campaignType)[0] == '0') ? $this->visit_start_date : ((array_keys($campaignType)[0] == '1') ? $this->deliver_start_date : $this->visit_start_date . ' ' . $this->deliver_start_date) : '';
            $end_date = (!empty($campaignType)) ? (array_keys($campaignType)[0] == '0') ? $this->visit_end_date : ((array_keys($campaignType)[0] == '1') ? $this->deliver_end_date : $this->visit_end_date . ' ' . $this->deliver_end_date) : '';
            $countries = $this->campaignCountries()->get()->map(function ($q) {
                $country = $q->country()->first();
                return $country->code;
            })->toArray();

        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand_name' => $this->brand()->first()->name,
            'countries' => $countries,
            'status' => $this->status,
            'campaign_status' => campaignStatusName($this->status),
            'target' => $this->target,
            'visits' => $visits,
            'total' => $this->campaignInfluencers->count(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'type_id' => array_keys($campaignType)[0] ?? '',
            'type' => array_values($campaignType)[0] ?? '',
        ];

    }
    public static function collection($resource)
    {
        return tap(new GlobalCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }
}
