<?php

namespace App\Http\Controllers\API\InfluencerDashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Influencer_dashboard\CampaignsResource;
use App\Models\CampaignInfluencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function getCampaigns(Request $request) // get all campaigns for influencer
    {
        $influencerId = $request->user()->influencers->id;

        $campaigns = CampaignInfluencer::where('influencer_id', $influencerId)->get();

        $response = $campaigns->isNotEmpty()
        ? response()->json(['status' => true, 'Campaigns' => CampaignsResource::collection($campaigns)], 200)
        : response()->json(['status' => false, 'Campaigns' => []], 200);

        return $response;
    }

    public function getCurrentCampaigns(Request $request) // get today's campaigns for influencer
    {
        $influencerId = $request->user()->influencers->id;

        $campaigns = CampaignInfluencer::where('influencer_id', $influencerId)
            ->where('status', 1)
            ->whereDate('confirmation_date', date('Y-m-d'))
            ->get();

        $response = $campaigns->isNotEmpty()
        ? response()->json(['status' => true, 'CurrentCampaigns' => CampaignsResource::collection($campaigns)], 200)
        : response()->json(['status' => false, 'CurrentCampaigns' => []], 200);

        return $response;
    }

    public function getUpcomingCampaigns(Request $request) //get approved campaigns
    {
        $limit = isset($request->per_page) ? $request->per_page : 10;
        $influencer = $request->user()->influencers->id;
        $filter = $request->only(['confirmed_date']);

        $confirmedCampaigns = CampaignInfluencer::where('influencer_id', $influencer)
            ->where('status', 1);

        if ($request->has('date')) { //for calendar
            $date = $request->date;
            if ($date == 1) { // all approved campaigns
                $confirmedCampaigns->whereDate('confirmation_date', '>=', date('Y-m-d'));
            } elseif ($date == 0) { // today's approved campaigns
                $confirmedCampaigns->whereDate('confirmation_date', date('Y-m-d'));
            }
        } else {
            $confirmedCampaigns->whereDate('confirmation_date', '>=', date('Y-m-d'));
        }

        $confirmedCampaigns = $confirmedCampaigns->filter($filter);

        $confirmedCampaigns = $limit != -1 ? $confirmedCampaigns->paginate($limit) : $confirmedCampaigns->get();

        $campaigns = $confirmedCampaigns->count() > 0
        ? CampaignsResource::collection($confirmedCampaigns)
        : [];

        return response()->json(['status' => !empty($campaigns), 'UpcomingCampaigns' => $campaigns], 200);
    }

    public function noneActionCampaigns(Request $request) //get pending campaigns
    {
        $influencerId = $request->user()->influencers->id;

        $campaigns = CampaignInfluencer::where('influencer_id', $influencerId)
            ->where('status', 0)
            ->get();

        $response = $campaigns->isNotEmpty()
        ? response()->json(['status' => true, 'NoneActionCampaigns' => CampaignsResource::collection($campaigns)], 200)
        : response()->json(['status' => false, 'NoneActionCampaigns' => []], 200);

        return $response;
    }

    public function confirmCampaign(Request $request) // action confirm campaign
    {
        $influencerId = $request->user()->influencers->id;

        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $campaign = CampaignInfluencer::where('campaign_id', $request->campaign_id)
            ->where('influencer_id', $influencerId)
            ->where('status', 0)
            ->first();

        if ($campaign) {
            $campaign->update([
                'status' => 1,
                'confirmation_date' => date('Y-m-d'),
            ]);

            return response()->json(['status' => true, 'message' => __('api.Campaign confirmed successfully')], 200);
        }

        return response()->json(['status' => false, 'message' => __('api.No campaign found')], 400);
    }

    public function rejectCampaign(Request $request)
    {
        $influencerId = $request->user()->influencers->id;

        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|array',
            'campaign_id.*' => 'required|integer|exists:campaigns,id',
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $campaigns = CampaignInfluencer::where('influencer_id', $influencerId)
            ->whereIn('campaign_id', $request->campaign_id)
            ->whereIn('status', [0, 1]) // pending or confirmed
            ->get();

        if ($campaigns->isEmpty()) {
            return response()->json(['status' => false, 'message' => __('api.No campaign found')], 400);
        }

        foreach ($campaigns as $campaign) {
            $campaign->update([
                'status' => 4,
                'reason_to_cancel' => $request->reason,
                'confirmation_date' => null,
                'confirmation_start_time' => null,
                'confirmation_end_time' => null,
            ]);
        }

        return response()->json(['status' => true, 'message' => __('api.Campaign rejected successfully')], 200);
    }


}
