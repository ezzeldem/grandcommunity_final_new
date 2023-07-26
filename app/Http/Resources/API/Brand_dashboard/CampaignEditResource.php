<?php

namespace App\Http\Resources\API\Brand_dashboard;

use App\Models\Branch;
use App\Models\Country;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class CampaignEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cities = collect($this->country_id)->mapWithKeys(function ($q, $i) {
            return [Country::find($q)->name => (int) $this->city_id[$i] ?? null];
        });

        // $groupList =  collect($this->country_id)->mapWithKeys(function ($q,$i){
        //     return [Country::find($q)->name => $this->list_ids[$i]??null];
        // });

        $statuses = Status::where('type', 'campaign_influencers')->select('id', 'name', 'value', )->get();

        $influencersCount = $this->campaignInfluencers()->count();

        /***************************************************************/

        $campaignCountries = $this->campCountryFavourite()->get();
        $campaignComplimentBranches = $this->campaign_branches()->where('has_compliment', 1)->get();
        $countries = $campaignCountries->map(function ($q) {
            return [
                'id' => $q->country_id,
                'name' => $q->country->name,
            ];
        });

        $campaignBranches = $this->campaign_branches()->get();
        $branches = $campaignBranches->map(function ($q) {
            return [
                'id' => $q->branche_id,
                'name' => $q->branch->name,
            ];
        });

        /***************************************************************/

        $countriesIds = $campaignCountries->map(function ($q) {
            return $q->country_id;
        });

        $branchesIds = $campaignBranches->map(function ($q) {
            return $q->branche_id;
        });

        $complimentBranchesIds = $campaignComplimentBranches->map(function ($q) {
            return $q->branche_id;
        });

        /***************************************************************/

        $objectives = updatedCampaignObjectivesArray();

        $objective_id = $this->objective_id;
        $objective_name = isset($objectives[$objective_id]) ? $objectives[$objective_id] : null;

        /***************************************************************/

        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand_name' => $this->brand->name,
            'campaign_type' => $this->campaign_type,
            'count' => $influencersCount,
            "countries" => $countries,
            "countries_ids" => $countriesIds,
            "branches" => $branches,
            "branches_ids" => $branchesIds,
            "statuses" => $statuses,
            'campaign_status' => $this->status,
            'cancel_type' => @$this->request_to_cancle,
            'after_reason' => @$this->reason && $this->request_to_cancle == 0 ? 3 : null,
            'has_guest' => $this->has_guest,
            'guest_numbers' => @$this->guest_numbers,
            'has_voucher' => @$this->has_voucher,
            'compliment_branches' => $complimentBranchesIds,
            'target' => $this->target,
            'gender' => (string) $this->gender,
            'visit_start_date' => ($this->visit_start_date) ? Carbon::parse($this->visit_start_date)->format("Y-m-d") : null,
            'visit_end_date' => ($this->visit_end_date) ? Carbon::parse($this->visit_end_date)->format("Y-m-d") : null,
            'deliver_start_date' => ($this->deliver_start_date) ? Carbon::parse($this->deliver_start_date)->format("Y-m-d") : null,
            'deliver_end_date' => ($this->deliver_end_date) ? Carbon::parse($this->deliver_end_date)->format("Y-m-d") : null,
            'influencer_per_day' => $this->influencer_per_day,
            'note' => $this->note,
            'whats_number' => $this->whats_number,
            'phone' => $this->phone,
            'sub_brand_id' => $this->sub_brand_id,
            'sub_brand_name' => ($this->subBrand) ? $this->subBrand->name : '',
            'visit_from' => ($this->visit_from) ? Carbon::parse($this->visit_from)->format("H:i") : null,
            'visit_to' => ($this->visit_to) ? Carbon::parse($this->visit_to)->format("H:i"): null,
            'delivery_from' => ($this->delivery_from) ? Carbon::parse($this->delivery_from)->format("H:i") : null,
            'delivery_to' => ($this->delivery_to) ? Carbon::parse($this->delivery_to)->format("H:i") : null,
            'brief' => $this->brief,
            'count_of_delivery' => $this->count_of_delivery,
            'list_ids' => $this->list_ids, //$groupList,
            'secrets' => $this->secrets->load('campaignCountry.country'),
            'sub_brand' => $this->subBrand,
            'rate' => $this->rate,
            'type' => $this->getType(),
            'campStatus' => $this->OfCampaginStatus(),
            'visit_coverage' => $this->visit_coverage,
            'scanner_link' => url('/Scanner/login'),
            'objective_id' => $objective_id,
            'objective_name' => $objective_name,
            'attached_files' => @$this->attached_files,
            'compliment_type' => @$this->compliment_type,
            'voucher_amount' => @$this->compliment->voucher_amount,
            'voucher_amount_currency' => @$this->compliment->voucher_amount_currency,
            'voucher_expired_date' => ($this->compliment->voucher_expired_date) ? Carbon::parse($this->compliment->voucher_expired_date)->format("Y-m-d") : null,
            'voucher_expired_time' => ($this->compliment->voucher_expired_time) ? Carbon::parse($this->compliment->voucher_expired_time)->format("H:i") : null,
            'gift_image' => @$this->compliment->gift_image,
            'gift_amount' => @$this->compliment->gift_amount,
            'gift_amount_currency' => @$this->compliment->gift_amount_currency,
            'gift_description' => @$this->compliment->gift_description,
            'target_confirmation' => $this->daily_influencer,
            'daily_confirmation' => $this->daily_confirmation,
        ];
    }

}
