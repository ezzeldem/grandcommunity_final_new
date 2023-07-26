<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\City;
use App\Models\GroupList;
use App\Models\State;
use App\Models\Status;
use App\Models\Comment;
use App\Models\Subbrand;
use Illuminate\View\View;
use App\Models\Influencer;
use Illuminate\Http\Request;
use App\Models\CampaignInfluencer;
use App\Models\InfluencerComplain;
use App\Http\Traits\FileAttributes;
use App\Http\Controllers\Controller;
use App\Models\CampaignInfluencerVisit;
use App\Models\InfluencerComplainReply;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\ComplainRequest;
use App\Http\Requests\Admin\GroupListRequest;
use App\Http\Requests\Admin\InfluencerRequest;
use App\Http\Requests\Admin\ConfirmationRequest;
use App\Repository\Interfaces\GroupListInterFace;
use App\Repository\Interfaces\InfluencerInterface;
use App\Http\Traits\SocialScrape\SnapchatScrapeTrait;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;

class InfluencerController extends Controller
{
    use FileAttributes, InstagramScrapeTrait, SnapchatScrapeTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $group;
    protected $influencer;

    public function __construct(GroupListInterFace $group, InfluencerInterface $influencer)
    {
        $this->middleware('permission:read influencers|create influencers|update influencers|delete influencers', ['only' => ['index', 'get', 'show', 'export']]);
        $this->middleware('permission:create influencers', ['only' => ['create', 'store', 'import', 'create_group', 'AddInflue_to_group']]);
        $this->middleware('permission:update influencers', ['only' => ['edit', 'update', 'statusToggle', 'edit_all']]);
        $this->middleware('permission:delete influencers', ['only' => ['destroy', 'delete_all']]);
        $this->group = $group;
        $this->influencer = $influencer;
    }
    /**index
     * @return mixed
     */
    public function index()
    {
        return $this->influencer->index();
    }

    /**get Influencer datatable data
     * @return mixed
     */
    public function getInfluencer(Request $request)
    {

        return $this->influencer->getInfluencer($request);
    }
    public function getInfluencerdata()
    {

        return $this->influencer->getInfluencerdata();
    }
    public function UpdateInfluencerdata()
    {

        return $this->influencer->UpdateInfluencerdata();
    }
    /**get Influencer nationalities data
     * @return mixed
     */
    public function getNationalities()
    {
        return $this->influencer->getNationalities();
    }

    public function getCountries()
    {
        return $this->influencer->getCountries();
    }
    public function getGovernorate()
    {
        return $this->influencer->getGovernorate();
    }

    public function getStatesListByCountryId(Request $request){
        $states = State::where('country_id', (int) $request->country_id)->select('id', 'name')->get();
        $states = $states->map(function ($state) {
            return ['key' => $state->id, 'value' => $state->name];
        });
        return response()->json(['status' => true, 'options' => $states], 200);
    }

    public function getSubBrandsListByBrandId(Request $request){
        $groups = Subbrand::where('brand_id', (int) $request->brand_id)->where('status', 1)->select('id', 'name')->get();
        $groups = $groups->map(function ($group) {
            return ['key' => $group->id, 'value' => $group->name];
        });
        return response()->json(['status' => true, 'options' => $groups], 200);
    }

    public function getGroupsListBySubBrandId(Request $request){
        $groups = GroupList::where('sub_brand_id', (int) $request->sub_brand_id)->select('id', 'name')->get();
        $groups = $groups->map(function ($group) {
            return ['key' => $group->id, 'value' => $group->name];
        });
        return response()->json(['status' => true, 'options' => $groups], 200);
    }

    public function getGroupsListByBrandId(Request $request){
        $groups = GroupList::where('brand_id', (int) $request->brand_id)->select('id', 'name')->get();
        $groups = $groups->map(function ($group) {
            return ['key' => $group->id, 'value' => $group->name];
        });
        return response()->json(['status' => true, 'options' => $groups], 200);
    }

    public function getCitiesListByStateId(Request $request){
        $cities = City::where('state_id', (int) $request->state_id)->select('id', 'name')->get();
        $cities = $cities->map(function ($city) {
            return ['key' => $city->id, 'value' => $city->name];
        });
        return response()->json(['status' => true, 'options' => $cities], 200);
    }

    public function getBrand(){
        return $this->influencer->getBrand();
    }
    public function getStatus()
    {
        return $this->influencer->getStatus();
    }

    public function regenerateCodes($id)
    {
        return $this->influencer->regenerateCodes($id);
    }

    /**
     * create influencer.
     *
     * @return mixed
     */
    public function create()
    {
        // dd(trans('validation.required'));
        return  $this->influencer->create();
    }

    /**
     * Store a newly created resource in Influencer.
     *
     * @param  InfluencerRequest  $request
     * @return View
     */
    public function store(InfluencerRequest $request)
    {
        return $this->influencer->store($request);
    }

    /**
     * Show the form for editing the specified Influencer.
     *
     * @param  Influencer   $influence
     * @return View
     */
    public function edit(Influencer $influence)
    {
        return $this->influencer->edit($influence);
    }

    /**
     * Update the specified Influencer.
     *
     * @param InfluencerRequest  $request
     * @param Influencer  $influence
     * @return View
     */
    public function update(InfluencerRequest $request, Influencer $influence)
    {
        return $this->influencer->update($request, $influence);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Influencer $influence
     * @return Response
     */
    public function destroy(Influencer $influence)
    {
        return $this->influencer->destroy($influence);
    }

    /**import From Excel
     * @return mixed
     */
    public function import()
    {
        return $this->influencer->import();
    }

    /**export Excel
     * @param Request $request
     * @return mixed
     */
    public function export(Request $request)
    {
        return $this->influencer->export($request);
    }

    /**delete_all for Bulk Delete
     * @param Request $request
     * @return mixed
     */
    public function delete_all(Request $request)
    {
        return $this->influencer->delete_all($request);
    }

    /**edit_all for Bulk Delete
     * @param Request $request
     * @return mixed
     */
    public function edit_all(Request $request)
    {
        return $this->influencer->edit_all($request);
    }


    /**create_group
     * @param GroupListRequest $request
     * @return mixed
     */
    public function create_group(GroupListRequest $request)
    {
        $groups = $this->group->create_groups($request);
        return response()->json(['status' => 'true', 'data' => $groups], 200);
    }

    /**Add Influencer to group
     * @param Request $request
     * @return mixed
     */
    public function AddInflue_to_group(Request $request)
    {
        //fixme::groupUpdates
        $data = $this->influencer->AddInflue_to_group($request);
        return response()->json($data);
    }

    /**restore all
     * @param Request $request
     * @return mixed
     */
    public function restore_all(Request $request)
    {
        return $this->influencer->restore_all($request);
    }

    /**restore disliked all
     * @param Request $request
     * @return mixed
     */
    public function restore_influ_dislikes(Request $request)
    {
        return $this->influencer->restore_influ_dislikes($request);
    }

    /**delete all favourite
     * @param Request $request
     * @return mixed
     */
    public function delete_fav_all(Request $request)
    {
        return $this->influencer->delete_fav_all($request);
    }

    /**getCountryState
     * @param $id
     * @return mixed
     */
    public function getCountryState($id)
    {
        return $this->influencer->getCountryState($id);
    }

    /**getCityState
     * @param $id
     * @return mixed
     */
    public function getCityState($id)
    {
        return $this->influencer->getCityState($id);
    }

    /**getScrape
     * @param $id
     * @return mixed
     */
    public function getScrape($id)
    {

        return $this->influencer->getScrape($id);
    }


    protected function statictics()
    {

        if (request()->has('country_id')) {

            $statistics['totalInfluencer'] = ['title' => 'Total Influencers', 'id' => 'Total_Influencer', 'count' => Influencer::where('country_id', request('country_id'))->count(), 'icon' => 'fab fa-bandcamp'];
            $statistics['activeInfluencer'] = ['title' => 'Active Influencers', 'id' => 'Active_Influencer', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "1")->count(), 'icon' => 'fas fa-toggle-on'];
            $statistics['inactiveInfluencer'] = ['title' => 'Inactive Influencers', 'id' => 'Inactive_Influencer', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "2")->count(), 'icon' => 'fas fa-toggle-off'];
            $statistics['PendingInfluencer'] = ['title' => 'Pending Influencers', 'id' => 'Pending_Influencer', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "0")->count(), 'icon' => 'fas fa-grin-tongue'];
            $statistics['RejectInfluencer'] = ['title' => 'Rejectd Influencers', 'id' => 'Reject_Influencer', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "3")->count(), 'icon' => 'fas fa-times-circle'];
        } else {
            $statistics['totalInfluencer'] = ['title' => 'Total Influencers', 'id' => 'Total_Influencer', 'count' => Influencer::count(), 'icon' => 'fab fa-bandcamp'];
            $statistics['activeInfluencer'] = ['title' => 'Active Influencers', 'id' => 'Active_Influencer', 'count' => Influencer::where('active', "1")->count(), 'icon' => 'fas fa-toggle-on'];
            $statistics['inactiveInfluencer'] = ['title' => 'Inactive Influencers', 'id' => 'Inactive_Influencer', 'count' => Influencer::where('active', "2")->count(), 'icon' => 'fas fa-toggle-off'];
            $statistics['PendingInfluencer'] = ['title' => 'Pending Influencers', 'id' => 'Pending_Influencer', 'count' => Influencer::where('active', "0")->count(), 'icon' => 'fas fa-grin-tongue'];
            $statistics['RejectInfluencer'] = ['title' => 'Rejected Influencers', 'id' => 'Reject_Influencer', 'count' => Influencer::where('active', "3")->count(), 'icon' => 'fas fa-times-circle'];
        }
        return $statistics;
    }

    /**snapchatData
     * @param Request $request
     * @return mixed
     */
    public function snapchatData(Request $request)
    {
        return $this->influencer->snapchatData($request);
    }

    public function acceptInfluencer(Influencer $influencer, Request $request)
    {

        if ($request['data_flag'] == 'active') {
            $status_influencer = 1;
            if ($request['expire_date'] != -1) {
                $updated_data = ['active' => $status_influencer, 'expirations_date' => $request['expire_date']];
                $validator = Validator::make($updated_data, [
                    'expirations_date' => [
                        'after:today'
                    ]
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'message' => $validator->errors()], 200);
                }
            } else {
                $updated_data = ['active' => $status_influencer];
            }
        } elseif ($request['data_flag'] == 'inactive') {

            $status_influencer = 0;
            $updated_data = ['active' => $status_influencer];
        } elseif ($request['data_flag'] == 'rejected') {
            $status_influencer = 3;
            $updated_data = ['active' => $status_influencer];
        }
        $influencer->update($updated_data);

        return response()->json(['status' => true, 'stats' => $this->statictics(), 'message' => __('accept successfully')]);
    }

    public function get_influencer_complain(Request $request)
    {
        $comp = InfluencerComplain::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->first();
        return response()->json(['status' => true, 'influencerComplain' => $comp]);
    }

    public function get_influencer_confirmation(Request $request)
    {
        $comp = CampaignInfluencer::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->first();
        return response()->json(['status' => true, 'influencerConfirmation' => $comp]);
    }

    public function get_influencer_visits(Request $request)
    {
        $comp = CampaignInfluencer::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->first();
        return response()->json(['status' => true, 'influencerVisits' => $comp->CampaignInfluencerVisit->toArray()]);
    }


    public function get_influencer_details(Request $request)
    {

        $influence = Influencer::with('user', 'changeDetail')->find($request->influencer_id);
        $socialStatus = Status::where('type', 'influencer')->select('id', 'name', 'value')->get();
        $influence->address_ar = ($influence->changeDetail) ? $influence->changeDetail->address['ar'] : $influence->address->ar ?? '--';
        $influence->address_en = ($influence->changeDetail) ? $influence->changeDetail->address['en'] : $influence->address->en ?? '--';
        $influence->countryName = ($influence->changeDetail) ? $influence->changeDetail->country->name : $influence->country->name ?? '--';
        $influence->cityName = ($influence->changeDetail) ? $influence->changeDetail->city->name : $influence->city->name ?? '--';
        $influence->stateName = ($influence->changeDetail) ? $influence->changeDetail->state->name : $influence->state->name ?? '--';
        return response()->json(['status' => true, 'influencerDetails' => $influence, 'socialStatus' => $socialStatus]);
        // return response()->json(['status'=>true, 'influencerDetails'=>[
        // 'influence'=>$influence ,
        // 'userinfluencer'=>$influence->user ,
        // ]]);
    }

    public function update_complain_status(Request $request)
    {
        $comp = InfluencerComplain::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->update(array_merge(['status' => $request->status]));
        return response()->json(['status' => true]);
    }

    public function complain_store(ComplainRequest $request)
    {

        $editStatus = $request->edit;
        if ($editStatus == 'true') {
            $comp = InfluencerComplain::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->first();
            if ($comp)
                $comp->update(['complain' => $request->complain]);
        } else {
            $comp = InfluencerComplain::create($request->validated());
        }
        return response()->json(['status' => true, 'complain' => $comp, 'alert' => [
            'icon' => 'success',
            'title' => 'success',
            'text' => 'complain added successfully'
        ]]);
    }

    public function update_confirmation(ConfirmationRequest $request)
    {

        $camp_influi = CampaignInfluencer::where('influencer_id', $request->influencer_id)->where('campaign_id', $request->campaign_id)->first();
        $camp_influi->update($request->validated());
        if ($request->status == 2) {
            $data = [
                'campaign_influencer_id' => $camp_influi->id,
                'actual_date' => $request->visit_date,
                'status' => $request->status,
                'branch_id' => $request->branch_id,
            ];
            CampaignInfluencerVisit::create($data);
        }
        return response()->json(['status' => true, 'alert' => [
            'icon' => 'success',
            'title' => 'success',
            'text' => 'Campaign Confirmation Updated Successfully'
        ]]);
    }



    /**delete_all for Bulk Delete
     * @param Request $request
     * @return mixed
     */
    public function influe_visits_delete_all(Request $request)
    {
        $visits = CampaignInfluencerVisit::destroy($request->selectedIds);
        return response()->json(['status' => true]);
    }


    public function  getAllInfluencer(Request $request)
    {
        if (request()->has('search')) {
            $influencedata = Influencer::where('insta_uname', 'like', '%' . $request->search . '%')->get();
            return response()->json(['msg' => 'success data', 'data' => $influencedata, 'status' => 1]);
        } else {
            $infl =   Influencer::with('user')->find(request()->id);
            $phone = $infl->user->phone;
            return response()->json(['msg' => 'success data', 'name' => $infl->name, 'phone' => $phone, 'status' => 1]);
        }
    }

    public function changeInfluencerStatus(Request $request)
    {
        $influence =   Influencer::find($request->influencer_id);
        if ($influence) {
            $influence->update(['active' => $request->status]);
            return response()->json(['msg' => 'success', 'influ' => $influence, 'status' => 200]);
        }
        return response()->json(['msg' => 'failed', 'status' => 500]);
    }


    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|max:255',
        ]);
        if (gettype(request()->id) == 'array') {
            Influencer::whereIn('id', request()->id)->delete();
        } else {

            Influencer::where('id', request()->id)->delete();
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 200);
            }
        }
    }
}
