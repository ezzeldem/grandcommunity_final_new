<?php

namespace App\Http\Resources\Admin;

use App\Models\Brand;
use App\Models\Country;
use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function PHPUnit\Framework\fileExists;

class CampaignInfluencerResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $no_of_uses = 0;
        $influencer = ($this->influencer()->exists()) ? $this->influencer()->first() : null;
        if (!$influencer) return [];
        $country = Country::where('id', (int)$this->country_id)->first();
        $camp_influencer = $influencer->campaignInfluencer()->where('campaign_type', $this->campaign_type)->where('country_id', (int)$this->country_id)->where('campaign_id', $this->campaign_id)->get();
        if ($camp_influencer->count() > 0) {
            $camp_influencer = $camp_influencer[0];
            $CampaignInfluencerVisit = $camp_influencer->CampaignInfluencerVisit()->get();

            $no_of_uses =  $CampaignInfluencerVisit->count();
        }

        $count_total_confirmation = $this->campaign->campaignInfluencers()->where('confirmation_date', '!=', NULL)->count();

        // dd( $this->campaignComplaint);
        $output = [
            'id' => $this->id,
            'full_name' => $influencer->name,
            'ig_name' => $influencer->insta_uname ?? '--',
            'folderId' => $this->campaign->folderId ?? '',
            'invetaion' => $this->invetaion ?? '--',
            'sn_name' =>  $influencer->snapchat_uname ?? '--',
            'visit_date' =>  $delivery_date ?? '--',
            'reason' =>  $this->reason ?? '--',
            'country' => $country ? Str::lower($country->code) : '',
            'engagement' => $influencer->engagement ? $influencer->engagement . ' %' : '',
            'addedAt' => $this->created_at,
            'followers' => $influencer->instagram->followers ?? '--',
            'rate' => $this->rate ?? '--',
            'qrCodeStatus' => (isset($this->influencer->qrcode) || isset($this->qr_code)) ? "yes" : '--',
            'confirmation_date' => ($this->confirmation_date) ? Carbon::parse($this->confirmation_date)->format('Y-m-d') : '--',
            'confirmation_start_time' => $this->confirmation_start_time,
            'confirmation_end_time' => $this->confirmation_end_time,
            'confirmation_start_end_time' => $this->confirmation_end_time." - ".$this->confirmation_end_time,
            'branches_names' => ($this->branch->name) ?? '--',
            'branches' => ($this->branch->id) ?? null,
            'brief' => ($this->brief == 1) ? 'Send' : ($this->brief == 0 ? 'Not Send' : '--'),
            'lang' => getLang($this->lang),
            'status' => campaignInfluencerStatus($this->status) ?? '',
            'date' => ($no_of_uses > 0 || isset($CampaignInfluencerVisit[0]->actual_date)) ? Carbon::parse($CampaignInfluencerVisit[0]->actual_date)->format('Y-m-d') : '__',
            'visit_date' => $this->visit_date,
            'influe_cover_status' => $this->campaing_coverage_status ?? '',
            'socials' => [
                'fb' => $influencer->facebook_uname,
                'insta' => $influencer->insta_uname,
                'tiktok' => $influencer->tiktok_uname,
                'snap' => $influencer->snapchat_uname,
                'twitter' => $influencer->twitter_uname,
            ],
            'complain' => $this->influencer_complain->where('campaign_id', $this->campaign_id)->first(),
            'total_confirmation' => $count_total_confirmation,
            'target_confirmation' => $this->campaign->daily_influencer,
        ];
        if ($this->campaign_type == 0) {

            $path = public_path('images/qrcode/' . str_replace(' ', '_', $this->influencer->country->name) . '/') . $this->influencer->qrcode;
            $output['role'] = [
                'user_name' => $influencer->user->user_name,
                'image' => $influencer->image,
                'qr_code' => isset($this->influencer->qrcode) ?? $this->qr_code,
                'qr_code_test' => $this->qr_code,
                'qr_code_test1' => $this->influencer->qrcode,
                'qr_link' => fileExists($path) ? asset('images/qrcode/') . '/' . str_replace(' ', '_', $this->influencer->country->name) . '/' . $this->influencer->qrcode : asset('images/qrcode/') . '/' . str_replace(' ', '_', $this->influencer->country->name) . '/' . $this->qr_code,
                'test_qr_code' => !empty($this->test_qr_code) ? $this->test_qr_code : null,
                'test_qr_link' => !empty($this->test_qr_code) ? asset('images/qrcode/') . '/' . str_replace(' ', '_', $this->influencer->country->name) . '/' . $this->test_qr_code : null,
                'code' => $this->influencer->influ_code ?? $this->influ_code,
                'test_code' => $this->test_influ_code,
                'qrcode_valid_times' => $this->qrcode_valid_times,
                'no_of_uses' => $no_of_uses,
                'influ_id' => $influencer->id,
                'camp_influ_id' => $this->id,
            ];
        } else {

            $delivery_date = Carbon::parse($this->visit_or_delivery_date);
            $date = $delivery_date->format('Y-m-d');
            $time = $delivery_date->format('H:i');
            $output['role'] = [
                'user_name' => $influencer->user_name,
                'address' => $influencer->address,
                'location' => $influencer->location,
                'phone' => $influencer->phone,
                'date' => $date,
                'time' => $time,
                'notes' => $this->notes,
                'influencer_id' => $influencer->id
            ];
        }

        $output['coverage_status'] = $this->coverage_status ?? '--';

        $output['coverage_date'] = $this->coverage_date ? Carbon::parse($this->coverage_date)->format('Y-m-d') : '--';
        return $output;
    }
}
