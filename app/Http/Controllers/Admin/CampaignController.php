<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CampaignExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CampaignRequest;
use App\Http\Requests\Admin\UpdateSecretKeysRequest;
use App\Http\Resources\Admin\CampaignInfluencerResource;
use App\Http\Services\CampaignService;
use App\Http\Services\Eloquent\Campaign as CustomModel;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CampaignCheckList;
use App\Models\CampaignCountryFavourite;
use App\Models\CampaignInfluencer;
use App\Models\CampaignSecret;
use App\Models\ComplimentCampaign;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\InfluencerComplain;
use App\Models\InfluencerComplainReply;
use App\Models\SecretPermission;
use App\Models\State;
use App\Models\Status;
use App\Repository\CampaignLogRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class CampaignController extends Controller
{
    //    $test_Log_Data = [
    //        'campaign_id' => 3,
    //        'influencer_id' => 0,
    //        'action_type' => 'create',
    //        'action' => 'add influencer to campaign',
    //    ];
    public $campaignService;
    public $customModel;
    public $campaignLog;

    public function __construct()
    {
        $this->customModel = new CustomModel();
        $this->campaignLog = new CampaignLogRepository();
        $this->campaignService = new CampaignService($this->customModel);
        $this->middleware('permission:read campaigns|create campaigns|update campaigns|delete campaigns', ['only' => ['index', 'show', 'export']]);
        $this->middleware('permission:create campaigns', ['only' => ['create', 'store']]);
        $this->middleware('permission:update campaigns', ['only' => [
            'edit', 'update', 'takeCamp', 'campDeliverDetails', 'noOfUses',
            'generateBrandUniquePassword', 'updateSecretStatus', 'updateCampaignStatus',
        ]]);
        $this->middleware('permission:delete campaigns', ['only' => ['destroy', 'bulkDelete', 'deleteBrandSecrete']]);
    }

    /**
     * Display a listing of the Campaigns.
     *
     * @return View
     */
    public function index()
    {
        $statistics['AllCampaigns'] = ['title' => 'All Campaigns', 'id' => 'all_Camp', 'count' => Campaign::count(), 'icon' => 'fab fa-bandcamp', 'value' => '-1'];
        $statistics['deliveryCampaigns'] = ['title' => 'Visit Campaigns', 'id' => 'visit_Camp', 'count' => Campaign::where('campaign_type', 0)->count(), 'icon' => 'fas fa-truck', 'value' => '0'];
        $statistics['visitCampaigns'] = ['title' => 'Delivery Campaigns', 'id' => 'delivery_Camp', 'count' => Campaign::where('campaign_type', 1)->count(), 'icon' => 'fas fa-people-carry', 'value' => '1'];
        $statistics['mixCampaigns'] = ['title' => 'Mixed Campaigns', 'id' => 'mix_Camp', 'count' => Campaign::where('campaign_type', 2)->count(), 'icon' => 'fas fa-mortar-pestle', 'value' => '2'];
        $statistics['share'] = ['title' => 'Share Campaigns', 'id' => 'share_Camp', 'count' => Campaign::where('campaign_type', 3)->count(), 'icon' => 'fas fa-mortar-pestle', 'value' => '3'];
        $statistics['postCreation'] = ['title' => 'Post Campaigns', 'id' => 'post_Camp', 'count' => Campaign::where('campaign_type', 4)->count(), 'icon' => 'fas fa-mortar-pestle', 'value' => '4'];
        $countries = Country::all();
        $types = campaignType();
        $status = $this->campaignService->getStatus();

        return view('admin.dashboard.campaign.index', compact('statistics', 'countries', 'status', 'types'));
    }

    /** datatable
     * @return mixed
     */
    public function datatable(Request $request)
    {
        return $this->campaignService->datatable($request);
    }

    /**
     * Show the form campaign
     *
     * @return View
     */
    public function create()
    {

        $brands = $this->campaignService->getBrands();
        $status = $this->campaignService->getStatus();
        $brand_countries = [];
        $selected_countries = [];
        $types = ['Visit', 'Delivery', 'Mix'];
        $objective = $this->campaignService->campaignObjectives();
        $chick_lists = CampaignCheckList::all();
        $platform = ['facebook', 'instagram', 'snapchat', 'tiktok', 'youtube'];
        return view('admin.dashboard.campaign.create', compact('brands', 'selected_countries', 'brand_countries', 'status', 'types', 'objective', 'platform', 'chick_lists'));
    }

    /**get States
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates()
    {

        $data = $this->campaignService->getStates();
        $branches = $data['branches'];
        $subbrands = $data['subbrands'];
        $groups = $data['groups'];
        return response()->json(['status' => true, 'branches' => $branches, 'groups' => $groups, 'subbrands' => $subbrands]);
    }

    /** getStateCities
     * @param $id
     * @return mixed
     */
    public function getStateCities($id)
    {
        return $this->campaignService->getStateCities($id);
    }

    public function permissionByType(Request $request)
    {
        //        dd($request->all());
        if ($request['type'] == 0) {
            $permissions = ['show Scanner Page', 'Search Manually', 'Show Confirmation', 'Show Pdf Report'];

            $per = SecretPermission::whereIn('name', $permissions)->get();
        } elseif ($request['type'] == 1) {
            $permissions = ['Show Delivery Page', 'Show Confirmation', 'Show Pdf Report'];
            $per = SecretPermission::whereIn('name', $permissions)->get();
        } elseif ($request['type'] == 2) {
            $permissions = ['show Scanner Page', 'Show Delivery Page', 'Search Manually', 'Show Confirmation', 'Show Pdf Report'];
            $per = SecretPermission::whereIn('name', $permissions)->get();
        } else {
            return response()->json(['status' => false, 'data' => []]);
        }
        if ($request['camp_id']) {
            $camp = Campaign::find($request['camp_id']);
            $secrets_permissions = $camp->secrets()->with(['permissions', 'campaignCountry'])->get();
            return response()->json(['status' => true, 'data' => $per, 'secrets_permissions' => $secrets_permissions]);
        }
        return response()->json(['status' => true, 'data' => $per]);
    }

    /** getSubBrands
     * @param $id
     * @return mixed
     */
    public function getSubBrands($id)
    {

        return $this->campaignService->getSubBrands($id);
    }

    /** get SubBrands Branches
     * @param $id
     * @return mixed
     */
    public function getSubBrandBranches($id)
    {

        return $this->campaignService->getSubBrandBranches($id);
    }

    /**
     * Store a newly created Campaign in storage.
     *
     * @param CampaignRequest $request
     * @return mixed
     */
    public function store(CampaignRequest $request)
    {
        if ((int)$request->step < 2 && (int)$request->step > 0) {
            return response()->json(['status' => true, "action" => "next_step", "message" => "Next step"], 200);
        }

        $branch = $request->branch_ids;
        $compliment_branches = $request->get('compliment_branches', []);
        $campaignData = $request->except(['phone', 'whatsapp', 'country_id', 'state_id', 'city_id', '_token', 'secret', 'permissions', 'branch_ids', 'voucher_branches', 'deliver_from', 'deliver_to', 'old_deliver_start_date', 'old_visit_start_date']);
        $campaignData['delivery_from'] = $request->deliver_from;
        $campaignData['delivery_to'] = $request->deliver_to;

        $campaignData['target'] = $request->target_influencer;
        $campaignData['influencer_per_day'] = $request->influencer_per_day;
        $campaignData['daily_influencer'] = $request->target_confirmation;
        $campaignData['daily_confirmation'] = $request->daily_confirmation;

        $campaign_id = $this->campaignService->createCampaign($campaignData, $branch, $compliment_branches);

        $campaign = Campaign::where('id', $campaign_id)->first();

        $request['influencers_price'] = 0;
        $request['total_price'] = 0;
        $campaign_country_fav = $request->only(['country_id', 'state_id', 'city_id', 'list_ids', 'campaign_type', 'secret', 'permissions']);

        $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);


        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign_id,
            'influencer_id' => 0,
            'action_type' => 'create',
            'action' => 'create new campaign',
        ]);
        dispatch(new \App\Jobs\CampaignTransfer(["campaign_id" => $campaign_id, "action_type" => "create"]));
        return response()->json(['status' => true, 'url' => '/dashboard/campaigns', 'message' => 'Campaign Stored successfully', 'action' => 'submitted'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Campaign $campaign
     * @return Response
     */
    public function show(Campaign $campaign)
    {

        return $this->campaignService->show($campaign);
    }

    public function campaignLog($id)
    {
        return $this->campaignService->campaignLog($id);
    }

    public function campaignLogAjax(Request $request, $id)
    {
        return $this->campaignService->campaignLogAjax($request, $id);
    }

    public function complainsAjax(Request $request, $id)
    {
        $campaignComplains = InfluencerComplain::where('campaign_id', $id)->with(['influencer', 'replies', 'replies.admin'])->get();
        return response()->json(['data' => $campaignComplains]);
    }

    public function addReply(Request $request)
    {
        $complain = InfluencerComplain::where('campaign_id', $request->campaign)->where('influencer_id', $request->influencer)->first();
        $inputs = [
            'complain_reply_id' => $complain->id,
            'reply_text' => $request->reply,
            'user_id' => auth()->user()->id,
        ];
        $complainReply = InfluencerComplainReply::create($inputs);
        $complainReply['admin'] = $complainReply->admin;
        return response()->json(['data' => $complainReply]);
    }

    /** campaignFavouriteListDatatables
     * @param $type 0->visit, 1->Delivery
     */
    public function campaignFavouriteListDatatables(Request $request)
    {
        // dd($request->all());
        $filter = $request->only(['country_val', 'campaign_type_val', 'camp_sub_type', 'qrcode_search_form_input', 'visitCheck', 'qrCheck', 'rateCheck', 'brief', 'coverage_status', 'custom']);

        $campaign = Campaign::find(request('camp_id'));

        $campaignInfluencers = paginateQuery($campaign->campaignInfluencers()->has('influencer')->groupBy('campaign_influencers.influencer_id')->filter($filter), $request->start, $request->length);

        if ($campaignInfluencers->count()) {
            $influencers = CampaignInfluencerResource::collection($campaignInfluencers);
            return datatables($influencers)
                ->setTotalRecords($campaignInfluencers->total())
                ->setFilteredRecords($campaignInfluencers->total())
                ->skipPaging()
                ->make(true);
        } else {
            return datatables([])->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return mixed
     */
    public function edit(Campaign $campaign)
    {
        $brand = Brand::findOrFail($campaign->brand_id);
        $user_branche = Branch::select('id', 'name')->where('brand_id', $campaign->brand_id)->get();
        $secrets = $campaign->secrets()->with('campaignCountry.country')->get();
        $campaign = $campaign->load('campaignCountries');
        $campaign['branchess'] = $campaign->branches;
        $brands = $this->campaignService->getBrands();
        $status = $this->campaignService->getStatus();
        $brand_countries = $brand->countries()->select('name', 'id')->get()->pluck('name', 'id')->toArray();
        $types = ['Visit', 'Delivery', 'Mix'];
        $objective = $this->campaignService->campaignObjectives();
        $chick_lists = CampaignCheckList::all();
        $platform = ['facebook', 'instagram', 'snapchat', 'tiktok', 'youtube'];
        $selected_countries = $campaign->country_id;
        $campaignCompliment = $campaign->compliment ?: new ComplimentCampaign;
        return view('admin.dashboard.campaign.edit', compact('brand', 'selected_countries', 'campaignCompliment', 'brands', 'types', 'status', 'platform', 'campaign', 'brand_countries', 'secrets', 'user_branche', 'objective', 'chick_lists'));
    }

    public function updateCampaignQuality(Request $request, $campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $campaign->update(['campaign_check_list' => $request->get('chicklist', [])]);
        return response()->json(['status' => true, 'url' => route('dashboard.campaigns.show', $campaign->id), 'message' => 'Campaign Stored successfully', 'action' => 'submitted'], 200);
    }

    public function updateCampaignSecretKeys(UpdateSecretKeysRequest $request, $campaign_id)
    {
        $campaign = Campaign::find($campaign_id);
        $campaign_country_fav = ['country_id' => $campaign->country_id, 'state_id' => null, 'city_id' => null, 'list_ids' => [], 'campaign_type' => $campaign->campaign_type, 'secret' => $request->secret, 'permissions' => $request->permissions];
        $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);
        return response()->json(['status' => true, 'url' => route('dashboard.campaigns.show', $campaign->id), 'message' => 'Campaign Stored successfully', 'action' => 'submitted'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return JsonResponse
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {

        if ((int)$request->step < 2 && (int)$request->step > 0) {
            return response()->json(['status' => true, "action" => "next_step", "message" => "Next step"], 200);
        }

        $campaign_id = $this->campaignService->updateCampaign($request, $campaign);
        if ($request->has('country_id') && $request->has('list_ids')) {
            $campaign_country_fav = $request->only(['country_id', 'state_id', 'city_id', 'list_ids', 'campaign_type', 'secret', 'permissions']);
            $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);
        }

        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign_id,
            'influencer_id' => 0,
            'action_type' => 'update',
            'action' => 'Update campaign',
        ]);

        Campaign::on('whats_app')->where('camp_id', $campaign->camp_id)->update([
            'name' => $request->name,

            'visit_start_date' => $request->visit_start_date,
            'visit_end_date' => $request->visit_end_date,
            'deliver_start_date' => $request->deliver_start_date,
            'deliver_end_date' => $request->deliver_end_date,

            'visit_from' => $request->visit_from,
            'visit_to' => $request->visit_to,
            'delivery_from' => $request->deliver_from,
            'delivery_to' => $request->deliver_to,

            'campaign_type' => $request->campaign_type,
            'invitation' => $request->invitation,
            'brief' => $request->brief,

        ]);

        dispatch(new \App\Jobs\CampaignTransfer(["campaign_id" => $campaign->id, "action_type" => "update"]));
        return response()->json(['status' => true, 'url' => '/dashboard/campaigns', 'message' => 'Campaign Stored successfully', 'action' => 'submitted'], 200);
    }

    public function takeCamp(Request $request)
    {
        $camp_influ = CampaignInfluencer::find($request['camp_influ']);
        $camp_influ->update([
            'take_campaign' => !((bool)$request['take_camp']),
        ]);
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return json
     */
    public function destroy(Campaign $campaign)
    {
        $campignId = $campaign->id;
        $campaignStatus = $campaign->status;
        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign->id,
            'influencer_id' => 0,
            'action_type' => 'delete',
            'action' => 'Delete campaign',
        ]);
        $campaign->delete();
        dispatch(new \App\Jobs\CampaignTransfer(["campaign_id" => $campignId, "action_type" => "delete"]));
        return response()->json(['status' => true, 'message' => 'Deleted successfully!'], 200);
    }

    /** bulkDelete
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDelete(Request $request)
    {
        if ($request->has('selected_ids')) {
            $ids = explode(',', $request['selected_ids']);
            Campaign::whereIn('id', $ids)->delete();
            return response()->json(['status' => true, 'message' => 'Deleted Successfully'], 200);
        } else {
            Campaign::whereIn('id', $request['id'])->delete();
            return response()->json(['status' => true, 'message' => 'Deleted Successfully'], 200);
        }
        return response()->json(['status' => false, 'message' => 'There is no campaign selected!'], 400);
    }

    /**campDeliverDetails
     * @param DeliverDetailRequest $request
     * @return JsonResponse
     */
    public function campDeliverDetails(DeliverDetailRequest $request)
    {
        $camp_influ = CampaignInfluencer::find($request->camp_influ_id);
        $camp_influ->update([
            'note' => $request->note,
            'visit_or_delivery_date' => $camp_influ->date . ' ' . $camp_influ->time,
            'notes' => $request->note,
        ]);
        $influencer = Influencer::find($request->influencer_id);
        $influencer->update([
            'address' => $request->address,
            'location' => $request->location,
            'phone' => $request->phone,
        ]);
        return response()->json(['status' => true, 'message' => 'Influencer Deliver Details Updated successfully'], 200);
    }

    /**noOfUses
     * @param Request $request
     * @return JsonResponse|void
     */
    public function noOfUses(Request $request)
    {
        $validator = $request->validate(['validTime_input' => 'required|numeric|max:10', 'camp_influ_id' => 'required|numeric|exists:campaign_influencers,id']);
        if ($validator) {
            $campInflu = CampaignInfluencer::find($validator['camp_influ_id']);
            $campInflu->update([
                'qrcode_valid_times' => $validator['validTime_input'],
            ]);

            return response()->json(['status' => true, 'message' => 'No Of Uses Updated successfully'], 200);
        }
    }

    /**getCampBranches
     * @param Request $request
     * @return JsonResponse
     */
    public function getCampBranches(Request $request)
    {
        $campaign = Campaign::find($request->camp_id);
        $allBranches = Branch::whereIn('id', $campaign->branch_ids)
            ->when($request->country_id != 0, function ($query) use ($request) {
                $query->where('country_id', $request->country_id);
            })->get();
        return response()->json(['status' => true, 'message' => 'No Of Uses Updated successfully', 'data' => $allBranches], 200);
    }

    /**generateBrandUniquePassword
     * @param int $length
     * @return JsonResponse
     */
    public function generateBrandUniquePassword($length = 10)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . '0123456789-=!@#$%^&*()_';
        $secret = substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 1, $length);
        $checkIfExist = CampaignSecret::whereSecret(Crypt::encryptString($secret))->get()->count();
        if ($checkIfExist > 0) {
            $secret = $this->generateBrandUniquePassword();
        }
        return response()->json(['status' => true, 'message' => 'Secret Key Returned Successfully', 'secret' => $secret], 200);
    }

    /**
     * @param $secret_id
     * @return JsonResponse
     */
    public function deleteBrandSecrete($secret_id)
    {
        CampaignSecret::find($secret_id)->delete();
        return response()->json(['status' => true, 'message' => 'Secret Key Deleted Successfully'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateSecretStatus(Request $request)
    {
        $brandSecret = CampaignSecret::find($request->id);
        $brandSecret->update([
            'is_active' => $request->is_active,
        ]);

        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $brandSecret->campaignCountry->campaign->id,
            'influencer_id' => 0,
            'action_type' => 'change_status',
            'action' => 'Change QrCode (' . $brandSecret->secret . ') status to ' . ($request->is_active == 1 ? 'Active' : 'In-Active'),
        ]);
        return response()->json(['status' => true, 'message' => 'Secret Key Status Updated Successfully'], 200);
    }

    /**toggleStatus
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus($id)
    {
        $campaign = Campaign::find($id);
        $status = 0;
        if ($campaign->status == 0) {
            $status = 1;
            if ($campaign->visit_start_date < Carbon::today() || (in_array($campaign->campaign_type, [1, 2]) && $campaign->deliver_start_date < Carbon::today())) {
                $status = 4;
            }
        }
        $campaign->update(['status' => $status]);

        return response()->json(['status' => true, 'active' => ($status > 0), 'message' => 'change successfully']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCampaignStatus(Request $request)
    {
        $campaign = Campaign::find($request->id);
        $campaign->update([
            'status' => $request->status,
        ]);
        $statusCamp = Status::where('type', 'campaign')->where('value', $campaign->status)->first();
        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign->id,
            'influencer_id' => 0,
            'action_type' => 'change_status',
            'action' => 'Change campaign status to ' . $statusCamp->name,
        ]);
        return response()->json(['status' => true, 'message' => 'Campaign Status Updated Successfully'], 200);
    }

    public function export()
    {
        return Excel::download(new CampaignExport(), 'campaigns.xlsx');
    }

    public function getInfluencersByCountry(Request $request)
    {
        $countries = $request->countries ? explode(',', $request->countries) : [];
        $influencers = Influencer::whereIn('country_id', $countries)->whereDoesntHave('campaignInfluencer')->pluck('name', 'id')->toArray();
        return response()->json(['data' => $influencers]);
    }

    public function addInfluencersToCampaign(Request $request)
    {
        $validator = Validator::make(['influencsers' => $request->influencsers], ['influencsers' => 'required|array']);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ), 422);
        }
        $campaign = Campaign::find((int)$request->campaignId);
        if (!$campaign) {
            return response()->json(array(
                'success' => false, 'message' => "Campaign not found.",
            ), 442);
        }

        $influencers = $request->influencsers;
        $influencersData = Influencer::whereIn('id', $influencers)->get();
        foreach ($influencersData as $influencer) {
            foreach ($campaign->country_id as $country) {
                if ($influencer->country_id == $country) {
                    CampaignInfluencer::updateOrCreate(['campaign_id' => $campaign->id, 'influencer_id' => $influencer->id, 'country_id' => $country], [
                        'influencer_id' => $influencer->id,
                        'brand_id' => $campaign->brand_id,
                        'campaign_id' => $campaign->id,
                        'campaign_type' => $campaign->campaign_type,
                        'country_id' => $country,
                        'status' => 0,
                    ]);
                }
            }
        }
        // foreach ($influencers as $influencer) {
        //     CampaignInfluencer::create([
        //         'influencer_id' => $influencer,
        //         'brand_id' => $request->brandId,
        //         'campaign_id' => $request->campaignId,
        //         'campaign_type' => $request->campaignType,
        //         'country_id' => $request->countryType,
        //         'status' => 0,
        //     ]);
        // }
        return response()->json(['msg' => 'Influencers Inserted Successfully', 'status' => 200]);
    }

    public function calenderData(Request $request)
    {
        $campaign = Campaign::find($request->campaign_id);
        if (!$campaign) {
            return response()->json(['success' => false, 'message' => 'Campaign not found.'], 500);
        }

        $influencersList = [];
        $influencersConfirmations = CampaignInfluencer::with('influencer')->where('campaign_id', (int)$request->campaign_id)->whereNotNull('confirmation_date')->get();
        foreach ($influencersConfirmations as $row) {
            if ($influencer = $row->influencer) {
                $influencersList[] = [
                    'id' => (int)$influencer->id,
                    'title' => (string)$influencer->name,
                    'start' => (string)$row->confirmation_date,
                    'image' => (string)$influencer->image,
                ];
            }
        }

        return response()->json(['success' => true, 'data' => $influencersList, 'message' => 'Success'], 200);
    }

    public function camp_coverage_update(Request $request)
    {
        $campaign = Campaign::find($request->id);
        $rules = [];
        $data = [];
        if ($request->type == 0) {
            $rules = [
                'coverage_visit' => 'required|url|max:255|min:20',
                'confirmation_link' => 'required|url|max:255|min:20',
            ];
        } elseif ($request->type == 1) {
            $rules = [
                'confirmation_delivery_link' => 'required|url|max:255|min:20',
                'delivery_coverage' => 'required|url|max:255|min:20',
            ];
        } else {
            $rules = [
                'confirmation_delivery_link' => 'required|url|max:255|min:20',
                'delivery_coverage' => 'required|url|max:255|min:20',
                'coverage_visit' => 'required|url|max:255|min:20',
                'confirmation_link' => 'required|url|max:255|min:20',
            ];
        }
        $validator = Validator::make($request->except(['_token']), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ), 422);
        }
        if ($campaign) {
            $campaign->update($validator->validated());
        }

        return response()->json(array(
            'success' => true,
            'message' => 'Updated Successfully',

        ), 200);
    }

    public function getcountriesselected()
    {
        $country = Country::whereIn('id', request()->countss)->get();
        return $country;
    }

    public function updateCampaign_Status(Request $request)
    {
        $campaign = Campaign::find($request->campaign_id);
        if ($campaign) {
            $campaign->update(['status' => $request->status]);
            return response()->json(['msg' => 'success', 'campaign' => $campaign, 'status' => 200]);
        }
        return response()->json(['msg' => 'failed', 'status' => 500]);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////

    public function approveCancelCampaign(Request $request)
    {
        $campaign = Campaign::find($request->id);
        if ($campaign && $campaign->reason != null && $campaign->request_to_cancle == 0 || $campaign->request_to_cancle == 2) {
            $campaign->update([
                'status' => 3,
                'request_to_cancle' => 1,
            ]);

            $this->campaignLog->SaveDataToLog([
                'campaign_id' => $campaign->id,
                'influencer_id' => 0,
                'user_id' => Auth::user()->id,
                'action_type' => 'change_status',
                'action' => 'Change campaign status to canceled',
            ]);
            return response()->json(['status' => true, 'message' => 'campaign canceled successfully', 'status' => 200]);
        }
        return response()->json(['status' => false, 'msg' => 'failed', 'status' => 400]);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////

    public function rejectCancelCampaign(Request $request)
    {
        $campaign = Campaign::find($request->id);

        if ($campaign && $campaign->reason != null && $campaign->request_to_cancle == 0) {
            $campaign->update([
                'request_to_cancle' => 2,
                'reason' => null,
            ]);
            $this->campaignLog->SaveDataToLog([
                'campaign_id' => $campaign->id,
                'influencer_id' => 0,
                'user_id' => Auth::user()->id,
                'action_type' => 'change_status',
                'action' => 'Reject to cancel campaign',
            ]);
            return response()->json(['status' => true, 'message' => 'cancel campaign rejected successfully', 'status' => 200]);
        }
        return response()->json(['status' => false, 'msg' => 'failed', 'status' => 400]);
    }

    public function CampaignInfluencerExport($id)
    {
        $camp_name = Campaign::where('id', $id)->value('name');
        //$filter = \request()->only(['camp_id']);
        return Excel::download(new \App\Exports\InfluencerCampaignExport($id), $camp_name . '_influencers.xlsx');
    }

    public function uploadReport(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'pdf_file' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->file('pdf_file')->isValid()) {
            $file = $request->file('pdf_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pdfs'), $fileName);
            $campaign = Campaign::find($request->campaign_id);
            $campaign->report_pdf = $fileName;
            $campaign->save();
            return response()->json(['success' => 'File uploaded successfully.']);
        }

        return response()->json(['error' => 'Invalid file.'], 400);
    }

    public function addNewInfluenecrsToCampaign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campaign_id' => 'required|exists:campaigns,id',
            'influencer_ids' => 'required|exists:influencers,id',
            'group_id' => 'required|exists:group_lists,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 400);
        }

        $campaign = Campaign::find($request->campaign_id);
        if (!$campaign) {
            return response()->json(['status' => false, 'message' => 'Campaign not found.'], 400);
        }

        $influencers = $request->influencer_ids;
        $influencer_ids = explode(',', $influencers);
        $influencersData = Influencer::whereIn('id', $influencer_ids)->get();
        foreach ($influencersData as $influencer) {
            foreach ($campaign->country_id as $country) {
                if ($influencer->country_id == $country) {
                    CampaignInfluencer::create([
                        'influencer_id' => $influencer->id,
                        'brand_id' => $campaign->brand_id,
                        'campaign_id' => $campaign->id,
                        'campaign_type' => $campaign->campaign_type,
                        'country_id' => $country,
                        'status' => 0,
                        'list_id' => $request->group_id,
                    ]);
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Influencers Inserted Successfully'], 200);
    }
}
