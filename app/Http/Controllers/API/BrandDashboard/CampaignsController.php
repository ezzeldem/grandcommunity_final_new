<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BrandDashboard\CampaignRequest;
use App\Http\Resources\API\Brand_dashboard\CampaignEditResource;
use App\Http\Resources\API\CampaignResource;
use App\Http\Resources\API\CampaignShowResource;
use App\Http\Services\CampaignService;
use App\Http\Services\Eloquent\Campaign as CustomModel;
use App\Http\Services\pCloudService;
use App\Http\Traits\GroupListTraits;
use App\Http\Traits\ResponseTrait;
use App\Imports\AddInfluencerToCampImport;
use App\Imports\CampaignInfluencerImport;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\Status;
use App\Models\User;
use App\Repository\CampaignLogRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CampaignsController extends Controller
{
    use ResponseTrait, GroupListTraits;
    public $campaignService, $customModel;
    public $service;
    public $campaignLog;

    public function __construct(pCloudService $service)
    {
        $this->customModel = new CustomModel();
        $this->campaignService = new CampaignService($this->customModel);
        $this->campaignLog = new CampaignLogRepository();
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Route::currentRouteName() == 'api.v1.upcoming.campaigns') {
            $request['status_val'] = 4;
        } elseif (Route::currentRouteName() == 'api.v1.history.campaigns') {
            $request['status_val'] = 2;
        } elseif (Route::currentRouteName() == 'api.v1.active.campaigns') {
            $request['status_val'] = 1;
        } elseif (Route::currentRouteName() == 'api.v1.pending.campaigns') {
            $request['status_val'] = 0;
        } elseif (Route::currentRouteName() == 'api.v1.refused.campaigns') {
            $request['status_val'] = 3;
        }

        $brand = User::find(auth()->user()->id);
        $filter = $request->only(['campaign_type_val', 'status_val', 'target', 'min', 'max', 'country_val', 'start_date', 'end_date', 'searchTerm', 'sort', 'search_name','status']);
        $limit = $request->get('per_page') ? $request->get('per_page') : 10;
        $campaigns = $brand->brands
            ->campaigns()
            ->filter($filter)
            ->orderBy('campaigns.created_at', 'desc')
            ->get()
            ->paginate($limit);

        $count = [
            'all' => $brand->brands->campaigns()->count(),
            'pending' => $brand->brands->campaigns()->where('status', 0)->count(),
            'active' => $brand->brands->campaigns()->where('status', 1)->count(),
            'upcoming' => $brand->brands->campaigns()->where('status', 4)->count(),
        ];

        $paginatedCampaigns = CampaignResource::collection($campaigns);
        return response()->json(['count' => $count, 'campaigns' => $paginatedCampaigns, 'status' => true, 'errNum' => '0000', 'message' => __('api.Data Returned Successfully')]);
    }

    public function getCampaignData(Request $request)
    {
        $camp_id = $request->campId;
        $camp_data = Campaign::find($camp_id);
        $limit = $request->get('per_page') ? $request->get('per_page') : 5;

        $filter = $request->only(['camp_sub_type', 'per_page', 'field', 'status', 'type', 'searchTerm', 'brand_id', 'visit_or_delivery_date', 'country_id', 'branch_id', 'influencer_name', 'complaint']);
        if ($camp_data) {
            $data = $camp_data
                ->campaignInfluencers()
                ->has('influencer')
                ->filter($filter)
                ->orderBy('id', 'desc')
                ->get()
                ->unique()
                ->paginate($limit);

            $count = [
                'all' => CampaignInfluencer::where('campaign_id', $request->campId)->count(),
                'confirmed' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->where('status', 1)
                    ->count(),
                'attends' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->whereIn('status', [2, 7])
                    ->count(),
                'waiting' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->where('status', 5)
                    ->count(),
                'cancel' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->where('status', 4)
                    ->count(),
                'coverage' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->where('status', 7)
                    ->count(),
                'complaint' => $camp_data->influencer_complain()->count(),
                'missed' => CampaignInfluencer::where('campaign_id', $request->campId)
                    ->where('status', 3)
                    ->count(),
            ];

            $paginatedCampaigns = CampaignShowResource::collection($data);
            return response()->json(['count' => $count, 'camp_data' => $paginatedCampaigns, 'status' => true, 'errNum' => '0000', 'message' => __('api.Data Returned Successfully')]);
        } else {
            return response()->json(['status' => false, 'errNum' => '500', 'message' => __('api.Not Found Campaign')], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CampaignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        try {
            DB::beginTransaction();
            $request['influencers_price'] = 0;
            $request['total_price'] = 0;
            $campaignData = $request->except(['prefered_channel', 'user_handler', 'country_id', 'city_id', '_token']);
            $campaignData['brand_id'] = @auth()->user()->brands->id;
            $campaignData['influencers_price'] = $request->has('influencers_price') ? $request['influencers_price'] : 0;
            $campaignData['influencer_count'] = $request->has('influencer_count') ? $request['influencer_count'] : 0;
            $campaignData['total_price'] = $campaignData['influencers_price'] * $campaignData['influencer_count'];

            $request = $this->getListIdsRequest($request, $campaignData['brand_id']);

            $campaign_id = $this->campaignService->createCampaign($campaignData, $request['branch_ids'], $request['compliment_branches']);
            $campaign = Campaign::where('id', $campaign_id)->first();
            $campaign_country_fav = $request->only(['country_id', 'city_id', 'list_ids', 'campaign_type']);
            $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);
            DB::commit();
            return $this->returnSuccessMessage(__('api.campaign added successfully'));
        } catch (\Exception$e) {
            DB::rollBack();
            return $this->returnError(500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        if ($campaign) {
            $brand = auth()->user()->brands;
            if ($campaign->brand_id != $brand->id) {
                $this->returnError(null, __('api.campaign not belong to you'));
            }
            return $this->returnData('campaign', new CampaignEditResource($campaign));
        }
    }

    public function rate_campaign_show(Request $request)
    {
        $campaign = Campaign::where('id', $request->campId);
        if ($campaign) {
            $campaign->update([
                'rate' => $request->rateCamp,
                'comment_rate' => $request->commentRateCamp ? $request->commentRateCamp : null,
            ]);
            $camp = Campaign::find($request->campId);
            return $this->returnData('campaign', new CampaignEditResource($camp));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignRequest  $request
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $request['guest_numbers'] = $request['has_guest'] == true ? $request['guest_numbers'] : null;
        $request['brand_id'] = $campaign->brand_id;
        $request['total_price'] = $request['influencers_price'] * $request['influencer_count'];

        $this->campaignService->updateCampaign($request, $campaign);
        $campaign_country_fav = $request->only(['country_id', 'city_id', 'list_ids', 'campaign_type']);
            $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);
        return $this->returnSuccessMessage(__('api.successfully_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return $this->returnSuccessMessage(__('api.successfully_deleted'));
    }

    public function destroyAll(Request $request)
    {
        $ids = is_array($request['ids']) ? $request['ids'] : explode(',', $request['ids']);
        Campaign::whereIn('id', $ids)->delete();
        return $this->returnSuccessMessage(__('api.successfully_deleted'));
    }

    /**
     * @param CampaignRequest $request
     * @param $brand_id
     * @return CampaignRequest
     * @throws ValidationException
     */
    private function getListIdsRequest(CampaignRequest $request, $brand_id): CampaignRequest
    {
        if ($request['fav_list_type'] == 2) {
            $data = [];
            //            foreach ($request['city_id'] as $country => $city_id) {
            foreach ($request['country_id'] as $country_id) {
                $country = Country::findOrFail($country_id);
                $groupList = $this->brandGroupList($brand_id, $request['country_id']);
                if ($groupList->count() > 0) {
                    if ($firstGroup = $groupList[$country->name]->first()) {
                        $data[$country->name] = $firstGroup->id ?? null;
                    }
                }
            }
            //            }
            $request['list_ids'] = $data;
        } else {
            if (!$request->has('list_ids')) {
                $request['list_ids'] = null;
            }
        }
        return $request;
    }

    public function campaignStopVisits($id)
    {
        $campaign = Campaign::find($id);
        $influencers = $campaign->campaignInfluencers->where('confirmation_date', Carbon::today());
        foreach ($influencers as $influencer) {
            $influencer->update(['confirmation_date' => null, 'status' => 0]);
        }
        return response()->json(['status' => true, 'message' => __('api.Campaign visits stopped successfully')], 200);
    }

    public function holdCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        $status = campaignDetailsStatus(\request()->type);
        $campaign->update(['status' => $status->id]);
        return response()->json(['status' => true, 'message' => 'Campaign ' . $status->name . ' successfully'], 200);
    }

    public function cancelInfluencerCampaign(Request $request)
    {
        $campaign = Campaign::find($request->campaign_id);
        $influencers = $campaign->campaignInfluencers->whereIn('influencer_id', $request->influencers);
        foreach ($influencers as $influencer) {
            $influencer->update(['status' => 3, 'confirmation_date' => null]);
        }
        return response()->json(['status' => true, 'message' => __('api.Influencers were removed from this campaign successfully!')], 200);
    }

    public function removeInfluencers(Request $request)
    {
        $campaign = Campaign::find($request->campaign_id);
        $influencers = $campaign->campaignInfluencers->whereIn('influencer_id', $request->influencers);
        foreach ($influencers as $influencer) {
            $influencer->delete();
        }
        return response()->json(['status' => true, 'message' => __('api.Influencers deleted successfully')], 200);
    }

    public function addInfluencerImport(Request $request)
    {
        $message_success = '';
        $getAttr = new AddInfluencerToCampImport($request, ($dd = null));
        if ($request->has('influencers_ids')) {
            $ids = explode(',', $request->influencers_ids);
            $country_ids = explode(',', $request->country_id);
            // dd($country_ids);
            $influecers = Influencer::whereIn('id', $ids)->get();
            foreach ($influecers as $influecer) {
                if (in_array($influecer->country_id, $country_ids)) {
                    CampaignInfluencer::create([
                        'influencer_id' => $influecer->id,
                        'campaign_id' => $request->camp_id,
                        'country_id' => $influecer->country_id,
                        'status' => 0,
                        // 'campaign_type' => $request->campaign_type,
                        // 'brand_id' => $request->brand_id,
                    ]);
                }
            }
        } else {
            Excel::import($getAttr, $request->file);
        }
        $message_success = $getAttr->messages_success;
        return response()->json(['status' => true, 'message' => $message_success], 200);
    }

    public function requestNewDate(Request $request)
    {
        $campaign = Campaign::find($request->campaign_id);
        $influencers = $campaign->campaignInfluencers->whereIn('influencer_id', $request->influencers);
        $new_date = date('Y-m-d H:i:s', strtotime($request->new_date));
        if ($new_date >= Carbon::today()) {
            foreach ($influencers as $influencer) {
                $influencer->update(['status' => 4, 'confirmation_date' => $new_date]);
            }
        } else {
            return response()->json(['status' => false, 'message' => __('api.Date must be after tomorrow')], 400);
        }
        return response()->json(['status' => true, 'message' => __('api.Influencers updated successfully')], 200);
    }

    public function CampaignInfluencerImport($id, Request $request)
    {
        $message_success = '';
        $getAttr = new CampaignInfluencerImport($request, ($dd = null), $id);
        if ($request->has('influencers_ids')) {
            $ids = explode(',', $request->influencers_ids);
            $influecers = Influencer::whereIn('id', $ids)->get();

            foreach ($influecers as $influecer) {
                CampaignInfluencer::create([
                    'influencer_id' => $influecer->id,
                    'campaign_id' => $id,
                    'status' => 0,
                ]);
            }
        } else {
            Excel::import($getAttr, $request->file);
        }
        $message_success = $getAttr->messages_success;
        return response()->json(['status' => true, 'message' => $message_success], 200);
    }

    public function VisitedCampaignByInfluencerId(Influencer $influencer)
    {
        $limit = request()->get('per_page') ? request()->get('per_page') : 10;
        $search = request()->get('search') ? request()->get('search') : '';
        if (!$influencer) {
            return response()->json(['status' => false, 'message' => __('api.influencer does not exist')], 404);
        }

        $user = auth()->user();
        $campaigns = Campaign::select('campaigns.id', 'campaigns.name', 'campaign_influencers.visit_or_delivery_date', 'campaign_influencers.campaign_type')
            ->Join('campaign_influencers', 'campaigns.id', '=', 'campaign_influencers.campaign_id')
            ->where(['campaign_influencers.influencer_id' => $influencer->id, 'campaign_influencers.status' => 2])
            ->where(['campaigns.brand_id' => @$user->brands->id])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where('campaigns.name', 'like', "%{$search}%");
            })
            ->paginate($limit);

        $paginatecampaigns = $campaigns->toArray();
        $data['last_page'] = $paginatecampaigns['last_page'];
        $data['total'] = $paginatecampaigns['total'];
        $data['per_page'] = $paginatecampaigns['per_page'];
        $data['data'] = $campaigns->map(function ($campaign) {
            return [
                'id' => $campaign->id,
                'campaign_name' => $campaign->name,
                'visit_or_delivery_date' => Carbon::parse($campaign->visit_or_delivery_date)->format('Y-m-d H:i'),
                'campaign_type' => $campaign->campaign_type,
                'campagin_type_name' => $campaign->getType(),
            ];
        });
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    public function campaign_data()
    {
        $channel = [];
        $coverge = [];
        $campaignType = [];
        $compliment = [];

        $coverages = updatedCampaignObjectives();
        foreach ($coverages as $ele) {
            $coverge[] = ['id' => $ele->id, 'title' => $ele->title];
        }

        $channels = getCampaignCoverageChannels();
        foreach ($channels as $ele) {
            $channel[] = ['id' => $ele->id, 'title' => $ele->title];
        }

        $types = campaignType();
        if (\request('objective_id') == 2) {
            $campaignType[] = ['id' => 3, 'name' => $types[3]];
            $campaignType[] = ['id' => 4, 'name' => $types[4]];
        } else {
            foreach ($types as $i => $type) {
                $campaignType[] = ['id' => $i, 'name' => $type];
            }
        }

        $compliments = getCompliment();
        foreach ($compliments as $ele) {
            $compliment[] = ['id' => $ele->id, 'title' => $ele->title];
        }

        $data = ['coverages' => $coverge, 'channels' => $channel, 'campaignTypes' => $campaignType, 'compliments' => $compliment];
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    public function Subbrand_get_list()
    {
        $user = auth()->user();
        if ($user->type == 0 && ($brand = $user->brands)) {
            $data['branches'] = $brand
                ->branchs()
                ->select('id', 'name', 'subbrand_id')
                ->where('subbrand_id', \request('sub_brand'))
                ->where('status', 1)
                ->when(\request('countries') && \request('countries') != null, function ($q) {
                    $countries = is_array(\request('countries')) ? \request('countries') : explode(',', \request('countries'));
                    $q->whereIn('country_id', $countries);
                })
                ->get();

            $data['groupLists'] =$brand
                ->group_lists()
                ->select('id', 'name', 'color')
                ->where('sub_brand_id', \request('sub_brand'))
                ->whereNull('group_lists.deleted_at')
                ->when(\request('countries') && \request('countries') != null, function ($q) {
                    $countries = is_array(\request('countries')) ? \request('countries') : explode(',', \request('countries'));
                    $q->where(function ($q) use ($countries) {
                        foreach ($countries as $sing_cou) {
                            $q->orWhereJsonContains('country_id', $sing_cou);
                        }
                     });
                })
                ->distinct()
                ->groupBy('group_lists.id')
                ->get();

            return response()->json(['status' => true, 'data' => $data], 200);
        } else {
            return $this->returnError('', __('api.will access from influencer'));
        }
    }

    public function get_campaign_type_status()
    {
        $data['campaign_status'] = Status::whereType('campaign')->get(['id', 'name', 'value']);
        $data['campaign_type'] = CampaignSearch();
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    /****************************************************************************************************************************************/

    public function login_to_booking_campaign(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'influencer_code' => 'required|exists:influencers,code',
            'campaign_id' => 'required|exists:campaigns,camp_id',
        ]);

        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }

        $influencer = Influencer::whereCode($request->influencer_code)->firstOrFail();
        // $campaign_id = decrypt($request->campaign_id);
        $campaign = Campaign::where('camp_id', $request->campaign_id)->firstOrFail();
        if ($campaign->status != 1) {
            return response()->json(['status' => false, 'message' => __('api.campaign is not active.')], 400);
        }
        $check = CampaignInfluencer::where(['influencer_id' => $influencer->id, 'campaign_id' => $campaign->id])->first();

        if ($check->status == 1 || $check->status == 4) {
            return response()->json(['status' => false, 'message' => __('api.We have received your request')], 400);
        }
        if (!$check) {
            return response()->json(['status' => false, 'message' => __('api.influencer not in this campaign.')], 400);
        } else {
            $data['campaign'] = $this->get_campaign_data($campaign);
            return response()->json(['status' => true, 'data' => $data], 200);
        }
    }

    //////////////////////////////////////

    public function get_campaign_data($campaign)
    {
        $data['name'] = $campaign->name ?? '';
        $data['brief'] = $campaign->brief ?? '';
        $data['image'] = 'https://stoneycreeker.com/images/wallpaper/snowy_morning_1280x1024.jpg';
        $data['campaign_type'] = $campaign->getType() ?? '';

        $data['branches'] = $campaign->branches()->get(['branche_id', 'name']) ?? [];

        switch ($campaign->campaign_type) {
            case 0:
                $start = Carbon::parse($campaign->visit_start_date);
                $end = Carbon::parse($campaign->visit_end_date);
                break;
            case 1:
                $start = Carbon::parse($campaign->deliver_start_date);
                $end = Carbon::parse($campaign->deliver_end_date);
                break;
        }

        if ($start->isPast() || $end->isPast()) {
            $data['campaign_date'] = 'Expired';
        }

        $dates = [];
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $campaignInfluencersIDs = CampaignInfluencer::where('campaign_id', $campaign->id)
                ->pluck('id')
                ->toArray();
            $countInfluencersVisit = CampaignInfluencer::whereIn('influencer_id', $campaignInfluencersIDs)
                ->where('confirmation_date', '>=', Carbon::parse($date)->startOfDay($date))
                ->where('confirmation_date', '<=', Carbon::parse($date)->endOfDay($date))
                ->count();
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'status' => $countInfluencersVisit < $campaign->influencer_per_day ? 'available' : 'not-available',
            ];
        }
        $data['dates'] = $dates;
        return $data;
    }

    //////////////////////////////////////

    public function confirm_booking_campaign(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'branch_id' => 'required|exists:branches,id',
            'confirmation_date' => 'required|date',
        ]);
        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }
        return $this->booking_campaign_store($request, 1);
    }

    //////////////////////////////////////

    public function reject_booking_campaign(Request $request)
    {
        return $this->booking_campaign_store($request, 4);
    }

    //////////////////////////////////////

    public function booking_campaign_store($request, $status)
    {
        $validate = Validator::make($request->all(), [
            'influencer_code' => 'required|exists:influencers,code',
            'campaign_id' => 'required|exists:campaigns,camp_id',
        ]);

        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }

        $influencer = Influencer::whereCode($request->influencer_code)->firstOrFail();
        $campaign_id = decrypt($request->campaign_id);
        $campaign = Campaign::where('camp_id', $campaign_id)->firstOrFail();
        $check = CampaignInfluencer::where(['influencer_id' => $influencer->id, 'campaign_id' => $campaign->id])->first();
        if ($check->confirmation_date) {
            return response()->json(['status' => false, 'message' => __('api.We have received your request')], 400);
        }
        if ($check) {
            $check->confirmation_date = $request->confirmation_date;
            $check->branch_id = $request->branch_id;
            $check->status = $status;
            $check->update();
            return response()->json(['status' => true, 'data' => ''], 200);
        }
    }

    /****************************************************************************************************************************************/

    public function influencerCoverge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }

        $filter = $request->only('search');

        $campaignInfluencers = CampaignInfluencer::where('campaign_id', $request->campaign_id)
            ->where('status', 7)
            ->filter($filter)
            ->get();

        $campaignInfluencers = $campaignInfluencers
            ->map(function ($campaign) {
                $coverage_channels = $campaign->influencer->coverage_channel;
                $coverage_channels = array_map(function ($channel) {
                    $all_channels = getCampaignCoverageChannels();
                    foreach ($all_channels as $channels) {
                        if ($channels->id == $channel) {
                            return ['title' => $channels->title];
                        }
                    }
                }, $coverage_channels);

                $influencers = $campaign->influencer->insta_uname;

                $stories = $this->service->getFucntion($influencers);
                $images = [];
                $videos = [];

                foreach ($stories as $story) {
                    $ext = pathinfo($story, PATHINFO_EXTENSION);
                    if ($ext == 'mp4') {
                        $videos[] = $story;
                    } else {
                        $images[] = $story;
                    }
                }

                $new_stories['images'] = $images;
                $new_stories['videos'] = $videos;

                return [
                    'influencer_name' => $campaign->influencer->name ?? '',
                    'insta_username' => $campaign->influencer->insta_uname ?? '',
                    'coverage_date' => date('Y-m-d', strtotime($campaign->coverage_date)) ?? '',
                    'coverage_channels' => $coverage_channels ?? [],
                    'coverage_images' => $new_stories,
                ];
            })
            ->paginate(10);

        return response()->json(['status' => true, 'InfluencerCoverage' => $campaignInfluencers], 200);
    }

    /****************************************************************************************************************************************/

    public function channels_types(Request $request)
    {
        $channels = getCampaignCoverageChannels();
        return response()->json(['status' => true, 'Channels' => $channels], 200);
    }

    /****************************************************************************************************************************************/

    public function chart(Request $request)
    {
        $camp_id = $request->camp_id;
        $total_influencers = CampaignInfluencer::where('campaign_id', $camp_id)
            ->where('status', 7)
            ->count();
        $average_followers = CampaignInfluencer::where('campaign_id', $camp_id)
            ->where('status', 7)
            ->join('influencers', 'influencers.id', '=', 'campaign_influencers.influencer_id')
            ->join('scrape_instagrams', 'scrape_instagrams.insta_username', '=', 'influencers.insta_uname')
            ->avg('scrape_instagrams.followers');
        return response()->json(['status' => true, 'Total' => $total_influencers, 'Average' => $average_followers], 200);
    }

    /****************************************************************************************************************************************/

    public function request_to_cancel(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'campaign_id' => 'required|exists:campaigns,id',
            'reason' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->validationError($validate->errors());
        }

        $campaign = Campaign::where('id', $request->campaign_id)->firstOrFail();

        $campaign->reason = $request->reason;
        if ($campaign->request_to_cancle == 2) {
            $campaign->request_to_cancle = 0;
        }
        $campaign->update();

        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->user()->id,
            'action_type' => 'delete',
            'action' => 'Request to cancel campaign',
        ]);

        return response()->json(['status' => true, 'message' => __('api.Request Sent Successfully')], 200);
    }

    /****************************************************************************************************************************************/

    public function getCurrencyCode()
    {
        $currencies = currenciesList();
        return response()->json(['status' => true, 'currencies' => $currencies], 200);
    }

    /****************************************************************************************************************************************/

}
