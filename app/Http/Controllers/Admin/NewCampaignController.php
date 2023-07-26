<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\State;
use App\Models\Branch;
use App\Models\Status;
use App\Models\Country;
use App\Models\Campaign;
use App\Models\GroupList;
use Illuminate\View\View;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CampaignSecret;
use App\Exports\CampaignExport;
use App\Models\SecretPermission;
use App\Models\CampaignCheckList;
use Illuminate\Http\JsonResponse;
use App\Models\CampaignInfluencer;
use App\Models\InfluencerComplain;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Http\Services\CampaignService;
use App\Models\CampaignCoverageChannel;
use App\Models\InfluencerComplainReply;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use App\Repository\CampaignLogRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\CampaignRequest;
use App\Http\Requests\Admin\DeliverDetailRequest;
use App\Http\Services\Interfaces\CampaignInterface;
use App\Http\Services\Eloquent\Campaign as CustomModel;
use App\Http\Resources\Admin\CampaignInfluencerResource;

class NewCampaignController extends Controller
{
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
            'generateBrandUniquePassword', 'updateSecretStatus', 'updateCampaignStatus'
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

        $statistics['AllCampaigns'] = ['title' => 'All Campaigns', 'id' => 'all_Camp', 'count' => Campaign::count(), 'icon' => 'fab fa-bandcamp'];
        $statistics['deliveryCampaigns'] = ['title' => 'Visit Campaigns', 'id' => 'visit_Camp', 'count' => Campaign::where('campaign_type', 0)->count(), 'icon' => 'fas fa-truck'];
        $statistics['visitCampaigns'] = ['title' => 'Delivery Campaigns', 'id' => 'delivery_Camp', 'count' => Campaign::where('campaign_type', 1)->count(), 'icon' => 'fas fa-people-carry'];
        $statistics['mixCampaigns'] = ['title' => 'Mixed Campaigns', 'id' => 'mix_Camp', 'count' => Campaign::where('campaign_type', 2)->count(), 'icon' => 'fas fa-mortar-pestle'];
        $countries = Country::all();
        $types = campaignType();
        $status = $this->campaignService->getStatus();

        return view('admin.dashboard.campaignNew.index', compact('statistics', 'countries', 'status', 'types'));
    }

    /** datatable
     *   @return mixed
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
        $brand_countries = Country::all();
        $chick_lists = CampaignCheckList::all();
        $types = ['Visit', 'Delivery', 'Mix'];
        $objective = $this->campaignService->campaignObjectives();
        $platform = ['facebook', 'instagram', 'snapchat', 'tiktok', 'youtube'];
        return view('admin.dashboard.campaignNew.create', compact('brands', 'brand_countries', 'status', 'types', 'chick_lists', 'objective', 'platform'));
    }


    /**get States
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStates()
    {
        $data = $this->campaignService->getStates();
        $returnHTML =  $data['html'];
        $branches =  $data['branches'];
        $subbrands =  $data['subbrands'];
        return response()->json(['status' => true, 'html' => $returnHTML, 'branches' => $branches, 'subbrands' => $subbrands]);
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
            $permissions =  ['show Scanner Page', 'Show Reports', 'Search Manually'];

            $per = SecretPermission::whereIn('name', $permissions)->get();
        } elseif ($request['type'] == 1) {
            $permissions = ['Show Reports', 'Show Delivery Page'];
            $per = SecretPermission::whereIn('name', $permissions)->get();
        } elseif ($request['type'] == 2) {
            $permissions = ['show Scanner Page', 'Show Reports', 'Show Delivery Page', 'Search Manually'];
            $per = SecretPermission::whereIn('name', $permissions)->get();
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
     * @param  CampaignRequest  $request
     * @return mixed
     */
    public function store(CampaignRequest $request)
    {

     $voucher=$request->voucher_branches;
        $branch=$request->branch_ids;
        $campaignData = $request->except(['phone', 'whatsapp','country_id','state_id','city_id','list_ids', '_token','secret','permissions','branch_ids','voucher_branches']);
        $campaign_id = $this->campaignService->createCampaign($campaignData,$branch,$voucher);
        $campaign = Campaign::where('id',$campaign_id)->first();

        // dd($request->all());
        $postPlatForm =  handlePlatform($request->channel_id);
        if(count($postPlatForm) >0 ){
        foreach ($postPlatForm as $key => $type) {
                CampaignCoverageChannel::create([
                    'campaign_id' => $campaign->id,
                    'channel_id' => $request->channel_id[$key],
                    'posts' => $request['share_post_type_posts_' . $type] ?? null,
                    'stories' =>$request['share_post_type_story_' . $type] ?? null,
                    'reels' =>$request['share_post_type_reels_' . $type] ?? null,
                    'video' =>($type == 'Youtube' || $type == 'Tiktok' ? 1 : 0),
                    'campaign_type' => 0,
                ]);

        }
        }

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

        return response()->json(['status' => true, 'url' => '/dashboard/campaigns', 'message' => 'Campaign Stored successfully'], 200);

        return redirect()->route('dashboard.campaigns.index')->with(['successful_message' => 'Campaign Stored successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Campaign  $campaign
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

        $filter = $request->only(['country_val', 'campaign_type_val', 'camp_sub_type', 'qrcode_search_form_input', 'visitCheck', 'qrCheck', 'rateCheck', 'brief', 'coverage_status', 'custom']);
        $campaign = Campaign::find(request('camp_id'));
        $campaignInfluencers = $campaign->campaignInfluencers()->has('influencer')->filter($filter)->get();
        if ($campaignInfluencers->count()) {
            $influencers = CampaignInfluencerResource::collection($campaignInfluencers);
            return datatables($influencers)->make(true);
        } else {
            return datatables([])->make(true);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Campaign  $campaign
     * @return mixed
     */
    public function edit(Campaign $campaign)
    {
        $brand = Brand::findOrFail($campaign->brand_id);
        $user_branche = Branch::select('id', 'name')->where('brand_id', $campaign->brand_id)->get();
        // $brand_countries = $campaign->campaignCountries->mapWithKeys(function($item, $key) {
        //         return [$item->country->id => $item->country->name];
        //     })->toArray();
        $brand_countries = $brand->countries->pluck('name', 'id')->toArray();
        // dd($campaign->campaignCountries->with(['secrets']));
        $campaign['branchess'] = $campaign->branches;
        $secrets = $campaign->secrets()->with('campaignCountry.country')->get();
        //        dd($secrets[0]);
        $campaign = $campaign->load('campaignCountries');
        //        dd($campaign);
        // dd($secrets);
        return  view('admin.dashboard.campaignNew.edit', compact('campaign', 'brand_countries', 'secrets', 'user_branche'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignRequest  $request
     * @param  Campaign  $campaign
     * @return Response
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $campaign_id = $this->campaignService->updateCampaign($request, $campaign);
        if ($request->has('country_id') && $request->has('list_ids')) {
            $campaign_country_fav = $request->only(['country_id', 'state_id', 'city_id', 'list_ids', 'campaign_type', 'secret', 'permissions']);
            //    dd($campaign_country_fav,$request->all());
            $this->campaignService->campaignCountryFavourite($campaign, $campaign_country_fav);
        }
        //        if($request->has('secret') && $request->has('permissions') && count($request['secret'])==count($request['permissions'])){
        //            $this->campaignService->brandSecret($request);
        //        }
        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign_id,
            'influencer_id' => 0,
            'action_type' => 'update',
            'action' => 'Update campaign',
        ]);
        return response()->json(['status' => true, 'url' => '/dashboard/campaigns', 'message' => 'Campaign Updated successfully'], 200);
        // return redirect()->route('dashboard.campaigns.index')->with(['successful_message' => 'Campaign Updated successfully']);
    }

    public function takeCamp(Request $request)
    {
        $camp_influ = CampaignInfluencer::find($request['camp_influ']);
        $camp_influ->update([
            'take_campaign' => !((bool)$request['take_camp'])
        ]);
        return response()->json(['status' => true, 'message' => 'Updated successfully'], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign  $campaign
     * @return json
     */
    public function destroy(Campaign $campaign)
    {
        $this->campaignLog->SaveDataToLog([
            'campaign_id' => $campaign->id,
            'influencer_id' => 0,
            'action_type' => 'delete',
            'action' => 'Delete campaign',
        ]);
        $campaign->delete();

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
            'phone' => $request->phone
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
            $campInflu =  CampaignInfluencer::find($validator['camp_influ_id']);
            $campInflu->update([
                'qrcode_valid_times' => $validator['validTime_input']
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
        $chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . '0123456789-=!@#$%^&*()_';
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
            'is_active' => $request->is_active
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

        $campaign->update(['status' => 0]);
        return response()->json(['status' => true, 'active' => false, 'message' => 'change successfully']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCampaignStatus(Request $request)
    {
        $campaign = Campaign::find($request->id);
        $campaign->update([
            'status' => $request->status
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
        $validator = Validator::make(['country' =>   $request->country], ['country' => 'required']);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 422);
        }
        $influencers = Influencer::where('country_id', $request->country)->whereDoesntHave('campaignInfluencer')->get();
        return response()->json(['data' => $influencers]);
    }

    public function addInfluencersToCampaign(Request $request)
    {
        $validator = Validator::make(['influencsers' =>   $request->influencsers], ['influencsers' => 'required|array']);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 422);
        }
        $influencers = $request->influencsers;
        foreach ($influencers as $influencer) {
            CampaignInfluencer::create([
                'influencer_id' => $influencer,
                'brand_id' => $request->brandId,
                'campaign_id' => $request->campaignId,
                'campaign_type' => $request->campaignType,
                'country_id' => $request->countryType,
                'status' => 0,
            ]);
        }
        return response()->json(['msg' => 'Influencers Inserted Successfully', 'status' => 200]);
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
                'errors' => $validator->getMessageBag()->toArray()

            ), 422);
        }
        if ($campaign) {
            $campaign->update($validator->validated());
        }

        return response()->json(array(
            'success' => true,
            'message' => 'Updated Successfully'

        ), 200);
    }

    public function updateCampaign_Status()
    {
        dd(request()->all());
    }
}