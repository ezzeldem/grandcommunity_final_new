<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\ScannerConfirmedInfluenecrsResource;
use App\Http\Resources\API\ScannerInfluencerInfoResource;
use App\Http\Resources\API\ScannerLoginResource;
use App\Http\Resources\API\ScannerReportResource;
use App\Http\Traits\CustomCrypt;
use App\Http\Traits\ResponseTrait;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\CampaignInfluencerVisit;
use App\Models\CampaignSecret;
use App\Models\Influencer;
use App\Models\Notification;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    use ResponseTrait, CustomCrypt;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function scanner_login(Request $request)
    {
        $secret_key = $this->encrypt(($request->params['secretKey'] ?? uniqid()));
        $data = [];
        $today = Carbon::now()->toDateString();
        $camp_secret = CampaignSecret::where('secret', $secret_key)->where('is_active', 1)->first();
        if (!$camp_secret) {
            return response()->json(['status' => false, 'message' => 'SecretKey is invaild'], 422);
        }

        $campaign = ($camp_secret->campaignCountry) ? $camp_secret->campaignCountry->campaign : '';
        if (!$campaign) {
            return response()->json(['status' => false, 'message' => 'SecretKey is invaild'], 422);
        }

        $activecampaign = Campaign::where(['id' => $campaign->id, 'status' => 1])->where(function ($query) use ($today) {
            $query->orWhere('visit_end_date', '>=', $today)->orWhere('deliver_end_date', '>=', $today);
        })->first(['id', 'status']);

        if (!$activecampaign) {
            return response()->json(['status' => false, 'message' => 'SecretKey is invaild'], 422);
        }

        return response()->json(['status' => true, 'data' => new ScannerLoginResource($camp_secret)], 200);

    }

    public function getVisitReport(Request $req)
    {

        $limit = isset($req->per_page) ? $req->per_page : 10;
        $branch_id = ($req->header('branch-id')) ? $req->header('branch-id') : '';
        $campaign = Campaign::select('id', 'name', 'visit_start_date', 'visit_end_date', 'rate', 'comment_rate', 'has_guest')->WithoutAppends()->where('id', $req->camp_id)->first();
        if (!$campaign) {
            return response()->json(['status' => false, 'message' => 'server Error !!'], 500);
        }

        $options = ['parts' => 1, 'syntax' => CarbonInterface::DIFF_ABSOLUTE];
        $campaign->date = Carbon::parse($campaign->visit_start_date)->format('d,M') . ' - ' . Carbon::parse($campaign->visit_end_date)->format('d,M');
        $campaign->duartion = Carbon::parse($campaign->visit_end_date)->diffForHumans(Carbon::parse($campaign->visit_start_date), $options);

        $influencerVisits = Influencer::select('influencers.id', 'influencers.insta_uname', 'influencers.snapchat_uname', 'influencers.facebook_uname', 'influencers.twitter_uname', 'influencers.tiktok_uname', 'influencers.image', 'influencers.country_id')->join('campaign_influencers', 'campaign_influencers.influencer_id', '=', 'influencers.id')
            ->where(['campaign_influencers.campaign_id' => $req->camp_id, 'campaign_influencers.status' => 2])
            ->when(isset($req['start_date']) && !empty($req['start_date']), function ($query) use ($req) {
                $query->whereDate('campaign_influencers.visit_or_delivery_date', '>=', $req['start_date']);
            })->when(isset($req['end_date']) && !empty($req['end_date']), function ($query) use ($req) {
                $query->whereDate('campaign_influencers.visit_or_delivery_date', '>=', $req['end_date']);
            })->when((isset($req['search']) && $req['search'] != null), function ($query) use ($req) {
                $query->where(function ($query) use ($req) {
                    $query->orwhere('name', 'LIKE', '%' . $req['search'] . '%')
                        ->orwhere('insta_uname', 'LIKE', '%' . $req['search'] . '%')
                        ->orwhere('facebook_uname', 'LIKE', '%' . $req['search'] . '%')
                        ->orwhere('tiktok_uname', 'LIKE', '%' . $req['search'] . '%')
                        ->orwhere('snapchat_uname', 'LIKE', '%' . $req['search'] . '%')
                        ->orwhere('twitter_uname', 'LIKE', '%' . $req['search'] . '%');
                });
            })->paginate($limit);

        $paginateInfluencers = $influencerVisits->toArray();
        $influencer_data['last_page'] = $paginateInfluencers['last_page'];
        $influencer_data['total'] = $paginateInfluencers['total'];
        $influencer_data['per_page'] = $paginateInfluencers['per_page'];
        $influencer_data['data'] = ScannerReportResource::collection($influencerVisits);

        $data = ["campaign" => $campaign, "influencers" => $influencer_data];

        return response()->json(['status' => true, 'data' => $data], 200);

    }

    public function getConfirmedInfluencers(Request $request)
    {
        $limit = 10;
        $searchInput = request()->get('search');
        $campId = $request->camp_id;
        $countryId = $request->country_id;
        $influencers = Influencer::select('influencers.id', 'influencers.name')->WhereHas('campaigns', function ($q) use ($campId) {
            $q->where('campaign_id', $campId)->where('campaign_influencers.status', 1);
        })
            ->where('influencers.country_id', (int)$countryId)->when(!empty($searchInput), function ($query) use ($searchInput) {
                $query->where(function ($query) use ($searchInput) {
                    $query->where('influencers.name', 'LIKE', "%{$searchInput}%")->orwhere('influencers.insta_uname', 'LIKE', "%{$searchInput}%");
                });
            })->paginate($limit);

        $paginateInfluencers = $influencers->toArray();
        $data['last_page'] = $paginateInfluencers['last_page'];
        $data['total'] = $paginateInfluencers['total'];
        $data['per_page'] = $paginateInfluencers['per_page'];
        $data['data'] = $influencers->map(function ($influencer) {
            return ['id' => $influencer->id, 'name' => $influencer->name];
        });
        return $this->returnData('data', $data, 'influencers data');
    }

    /** scan influencer code && qrcode  */
    public function scanCode(Request $request)
    {

        try {
            \DB::beginTransaction();
            $campId = $request->camp_id;
            $countryId = $request->country_id;
            $branch_id = $request->header('branch-id') ? $request->header('branch-id') : 0;

            $scan_type = isset($request->scan_type) ? $request->scan_type : 2;
            $influencerqrcode = ($scan_type == 1 && $request->influencer_code) ? json_decode($request->influencer_code)->id : ''; //fixme::to avoid edit from frontend

            $current_date = \Carbon\Carbon::now()->timezone($request->country_timezone);
            $influencer_code = $request->influencer_code; //($influencerqrcode) ? $influencerqrcode->id : 0;
            $influencer = Influencer::where('country_id', $countryId)->when(!empty($scan_type), function ($q) use ($scan_type, $influencer_code, $influencerqrcode) {
                if ($scan_type == 2) {
                    $q->where('influ_code', $influencer_code);
                } elseif ($scan_type == 1) {
                    $q->where('influ_code', $influencerqrcode);
                } //fixme::to avoid edit from frontend
                elseif ($scan_type == 3) {
                    $q->where('id', $influencer_code);
                }

            })->first();

            if (!$influencer) {
                return response()->json(['status' => false, 'message' => 'this code is invalid', 'code' => '404']);
            }

            $Conf_Influ_Object = CampaignInfluencer::where(['campaign_id' => $campId, 'influencer_id' => $influencer->id]);
            if (!$Conf_Influ_Object->first()) {
                return response()->json(['status' => false, 'message' => 'this code is invalid', 'code' => '404']);
            }

            $confirmedInfluencer = $Conf_Influ_Object->first();
            $visits = CampaignInfluencerVisit::where('campaign_influencer_id', $confirmedInfluencer->id)->count();

            $visitData = ['camp_influ_id' => $confirmedInfluencer->id, 'scan_type' => $scan_type, 'current_date' => $current_date
                , 'no_guest' => 0, 'note' => '', 'branch_id' => $branch_id];

            $message = "success";
            if (!$visits || ($visits < $confirmedInfluencer->qrcode_valid_times)) {
                $incorrect = 0;
                $code = 200;
                $Conf_Influ_Object->update(['status' => 2, 'visit_or_delivery_date' => $current_date]);
            } else {
                $incorrect = 1;
                $code = 201;
                $message = "This code has been used before.you cannot use it more than once";
            }
            $visitData = array_merge($visitData, ['incorrect' => $incorrect]);
            $this->createVisitInstance($visitData);

            \DB::commit();
            return response()->json(['status' => true, 'message' => $message, 'data' => new ScannerInfluencerInfoResource($influencer), 'code' => $code]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['status' => false, 'message' => 'server Error !!'], 500);
        }
    }

    protected function createVisitInstance($data)
    {
        CampaignInfluencerVisit::create([
            'campaign_influencer_id' => $data['camp_influ_id'],
            'used_code_type' => $data['scan_type'],
            'actual_date' => $data['current_date'],
            'no_of_companions' => $data['no_guest'],
            'branch_id' => $data['branch_id'],
            'comment' => $data['note'],
            'status' => 2,
            'incorrect' => $data['incorrect'],
        ]);
    }

    public function updateInfluVisit(Request $request)
    {
        try {
            \DB::beginTransaction();
            $influencer = Influencer::find($request->influencer_id);
            if (!$influencer) {
                return response()->json(['status' => false, 'message' => 'influencer Doesnt exist']);
            }

            $visitData = [];
            if (isset($request->no_guest)) {
                $visitData['no_of_companions'] = $request->no_guest;
            }

            if (isset($request->note)) {
                $visitData['comment'] = $request->note;
            }

            if (isset($request->branch_id)) {
                $visitData['branch_id'] = $request->branch_id;
            }

            if (!empty($visitData)) {
                $InfluencerVisit = CampaignInfluencerVisit::where('id', $request->last_visit_id)->update($visitData);
            }

            \DB::commit();
            $influencer_name = ($influencer && $influencer->name) ? $influencer->name : $influencer->insta_uname;
            $userId = ($influencer && $influencer->id) ? $influencer->id : $influencer->id;
            $notification = new Notification();
            $notification->message = "The Campaign has been Visited successfully";
            $notification->user_id = $userId;
            $camaignvisit = CampaignInfluencerVisit::where('id', $request->last_visit_id)->first();
            $notify = $camaignvisit->notification()->save($notification);
            $campaign_name = $camaignvisit->campaignInfluncer->campaign->name;
            //broadcast(new CampaignVisitedNotification($influencer_name,$campaign_name,$notify));
            return response()->json(['status' => true, 'data' => $influencer_name, 'message' => 'Visit Saved Successfuly ! please take care of ']);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return response()->json(['status' => false, 'message' => 'server Error !!'], 500);
        }

    }

    public function rateInfluencer(Request $request)
    {

        try {
            $camp_id = $request->camp_id;
            $influencer_id = $request->influencer_id;
            $influencer = Influencer::find($request->influencer_id);
            if (!$influencer) {
                return response()->json(['status' => false, 'message' => 'influencer Doesnt exist']);
            }

            $campInfluObject = $influencer->campaignInfluencer()->where('campaign_id', $camp_id);
            if (!$campInfluObject->first()) {
                return response()->json(['status' => false, 'message' => 'influencer Doesnt exist']);
            }

            $updateData = [];
            if (isset($request->rate)) {
                $updateData['rate'] = $request->rate;
            }

            if (isset($request->comment_rate)) {
                $updateData['comment_rate'] = $request->comment_rate;
            }

            if ($campInfluObject->update($updateData)) {
                return response()->json(['status' => true, 'message' => 'rate Saved Successfuly']);
            } else {
                return response()->json(['status' => false, 'message' => 'server Error !!'], 500);
            }

        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => 'server Error !!'], 500);
        }
    }

    public function getConfirmedInfluenecrs(Request $request)
    {
        $limit = isset($request->per_page) ? $request->per_page : 10;
        $campaign_id = $request->camp_id;

        $campaign = Campaign::select('id', 'name', 'visit_start_date', 'visit_end_date')->where('id', $campaign_id)->first();

        $confirmedInfluencers = CampaignInfluencer::where('campaign_id', $campaign_id)->where('status', 1)->paginate($limit);

        if ($confirmedInfluencers->count() > 0) {
            $paginateInfluencers = $confirmedInfluencers->toArray();
            $influencer_data['last_page'] = $paginateInfluencers['last_page'];
            $influencer_data['total'] = $paginateInfluencers['total'];
            $influencer_data['per_page'] = $paginateInfluencers['per_page'];
            $influencer_data['data'] = ScannerConfirmedInfluenecrsResource::collection($confirmedInfluencers);

            $data = [
                'campaign' => [
                    'name' => $campaign->name,
                    'visit_start_date' => $campaign->visit_start_date,
                    'visit_end_date' => $campaign->visit_end_date,
                ],
                'influencers' => $influencer_data,
            ];

            return response()->json(['status' => true, 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'No Data Found'], 404);
        }
    }
}
