<?php

namespace App\Repository;

use App\Exports\InfluencerExport;
use App\Http\Traits\CustomCrypt;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;
use App\Http\Traits\SocialScrape\SnapchatScrapeTrait;
use App\Http\Traits\SocialScrape\TiktokScrapeTrait;
use App\Imports\InfluencerImport;
use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\BrandFav;
use App\Models\City;
use App\Models\Country;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerChild;
use App\Models\InfluencerClassification;
use App\Models\InfluencerGroup;
use App\Models\InfluencerPhone;
use App\Models\Interest;
use App\Models\Job;
use App\Models\Language;
use App\Models\matchCampaign;
use App\Models\Nationality;
use App\Models\ScrapeInstagram;
use App\Models\ScrapeSnapchat;
use App\Models\ScrapeTiktok;
use App\Models\State;
use App\Models\Status;
use App\Models\Subbrand;
use App\Models\User;
use App\Repository\Interfaces\InfluencerInterface;
use Carbon\Carbon;
use DataTables;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class InfluencerRepository implements InfluencerInterface
{
    use TiktokScrapeTrait, InstagramScrapeTrait, SnapchatScrapeTrait, CustomCrypt;

    public $staticInfluencerData;
    public $groupListRepository;
    public function __construct(StaticDataInfluencerRepository $staticInfluencerData, GroupListRepository $groupListRepository)
    {
        $this->staticInfluencerData = $staticInfluencerData;
        $this->groupListRepository = $groupListRepository;
    }

    public function getStaticInfluencerData()
    {
        $data = [
            'matchCampaigns' => matchCampaign::all(),
            'ethinkCategory' => $this->staticInfluencerData->ethinkCategory(),
            'face' => $this->staticInfluencerData->face(),
            'speak' => $this->staticInfluencerData->speak(),
            'socialClass' => $this->staticInfluencerData->socialClass(),
            'recommendedAnyCamp' => $this->staticInfluencerData->recommendedAnyCamp(),
            'fake' => $this->staticInfluencerData->fake(),
            'accountType' => $this->staticInfluencerData->accountType(),
            'citizenStatus' => $this->staticInfluencerData->citizenStatus(),
            'socialCoverage' => $this->staticInfluencerData->socialCoverage(),
            'share' => $this->staticInfluencerData->share(),
            'rating' => $this->staticInfluencerData->rating(),
            'chatResponseSpeed' => $this->staticInfluencerData->chatResponseSpeed(),
            'behavior' => $this->staticInfluencerData->behavior(),
            'hijab' => $this->staticInfluencerData->hijab(),
            'typePhone' => $this->staticInfluencerData->getTypePhone(),
            'coverageRating' => $this->staticInfluencerData->coverageRating(),
            'socialStatus' => User::getInfluencerSocialType(),
            'interests' => Interest::whereStatus(1)->get(),
            'followersType' => $this->staticInfluencerData->getfollowersType(),
        ];
        return $data;
    }

    public function index()
    {
        $filterStatus = request()->status ?? '';
        $brands = Brand::with('group_lists:id,name,brand_id,country_id')->where('status', 1)->get();
        $jobs = Job::all();
        foreach ($brands as $brand) {
            if ($brand['country_id']) {
                $brand['country_id'] = Country::whereIn('id', array_map('intval', $brand['country_id']))->select('id', 'code', 'name')->get();
            }
        }
        $campaign_status = Status::select('name', 'value')->where('type', 'campaign')->get();
        $status = Status::select('id', "name", 'value')->where('type', 'influencer')->get();

        $statistics = $this->statictics();
        $filterData = $this->getStaticInfluencerData();
        $socialStatus = User::getInfluencerSocialType();
        $interests = Interest::whereStatus(1)->get();
        if(session()->has('filter_datatables_values')){
            session()->forget('filter_datatables_values');
        }
        return view('admin.dashboard.influencers.index', get_defined_vars());
    }

    public function create()
    {
        $staticData = $this->getStaticInfluencerData();
        $categories = InfluencerClassification::where('status', 'category')->get(['id', 'name']);
        $nationalities = Nationality::all();
        $jobs = Job::all();
        $interests = Interest::whereStatus(1)->get();
        $languages = Language::whereStatus(1)->get();
        $socialStatus = User::getInfluencerSocialType();
        $statInflue = User::getInfluencerStatus();
        $channels = getCampaignCoverageChannels();
        $attitude = attitude();
        return view('admin.dashboard.influencers.create', get_defined_vars());
    }

    public function generateCodes($influencer)
    {
        $array = $this->checkCodeType($influencer);
        $influencer->update($array);
    }

    public function regenerateCodes($id)
    {
        $influencer = Influencer::where('id',$id)->first(['id','insta_uname','qrcode']);
        $influ_code = generateRandomCode();
        $updateArray = [
            'influ_code' => $influ_code,
            'qrcode' => generateQrcode($influencer, false, $influ_code),
        ];
        $influencer->update($updateArray);

        $timestamp = Carbon::now()->timestamp;
        $influencer_profile_url = url('/') . '/digial_card/' . $influencer->insta_uname . '/' . $this->encrypt($updateArray['influ_code']) . '_' . $timestamp;
        $qrcode_url = $influencer->qrcode;
        $influencer_code = $influencer->influ_code;

        return ["profile_url" => $influencer_profile_url, "influencer_code" => $influencer_code, 'qrcode_url' => $qrcode_url];
    }

    private function checkCodeType($influencer)
    {
        $updateArray = [];
        if (is_null($influencer->qrcode) && is_null($influencer->influ_code)) {
            $updateArray = [
                'influ_code' => generateRandomCode(),
                'qrcode' => generateQrcode($influencer?->user, $influencer->country?->name),
            ];
        } elseif (is_null($influencer->qrcode)) {
            $updateArray = [
                'qrcode' => generateQrcode($influencer?->user, $influencer->country->name),
            ];
        } elseif (is_null($influencer->influ_code)) {
            $updateArray = [
                'influ_code' => generateRandomCode(),
            ];
        }
        return $updateArray;
    }

    public function store($request)
    {
        $inputs = $request->except(['user_name', 'email', 'password', 'phone_code', 'whatsapp_code', 'is_main', 'phone_type', 'phone', 'main_phone', 'main_phone_code', 'platforms', 'channel_ids']);
        $inputs['address'] = $request->address;
        // $inputs['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);
        $inputs['code_whats'] = $request->whatsapp_code;
        $inputs['has_voucher'] = $request->has_voucher;
        $inputs['attitude_id'] = $request->attitude_id;
        $inputs['licence'] = $request->licence ? 1 : 0;
        $inputs['v_by_g'] = $request->v_by_g ? 1 : 0;
        $inputs['category_ids'] = $request->category_ids;
        $inputs['coverage_channel'] = $request->channel_ids;
		$inputs['vInflUuid'] = NULL;
        $inputs['user_id'] = $this->createUser($request);
        if ($request->has('classification_ids')) {
            $inputs['classification_ids'] = $request->classification_ids;
        }

		$socailData=Influencer::socailMediaInputs($request->get('social', []));
		$newInputs=array_merge($inputs,$socailData);

        $influencer_data = Influencer::create($newInputs);
        if (is_array($request->phone) && is_array($request->phone_type) && is_array($request->phone_code) && count($request->phone) > 0 && count($request->phone_type) > 0 && count($request->phone_code) > 0) {
            foreach ($request->phone as $key => $dataphone) {
                $phones[] = ['influencer_id' => $influencer_data->id, 'code' => $request->phone_code[$key], 'phone' => $dataphone, 'type' => $request->phone_type[$key], 'is_main' => 0, 'user_type' => 1];
            }
            InfluencerPhone::insert($phones);
        }

        if ($request->children_num > 0 && is_array($request->childname) && count($request->childname) > 0) {
            foreach ($request->childname as $key => $child) {
                $children[] = ['influencer_id' => $influencer_data->id, 'child_name' => $child, 'child_gender' => isset($request->childgender[$key])?$request->childgender[$key]:"male", 'child_dob' => $request->childdob[$key] ?? "1976-01-30"];
            }
            InfluencerChild::insert($children);
        }

        $this->generateCodes($influencer_data);
        return response()->json(['status' => true, 'route' => route('dashboard.influences.index'), 'message' => 'Influencer Stored successfully'], 200);
    }

    public function createUser($request): int
    {
        $data = [
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => $request->password,
            'type' => 1,
            'code' => $request->main_phone_code,
            'phone' => $request->main_phone,
        ];
        $user = User::create($data);
        return $user->id;
    }

    public function socialScrap($influencer_data)
    {
        $dataTiktok = ['influe_brand_id' => $influencer_data->id, 'type' => 1, 'tiktok_username' => $influencer_data->tiktok_uname];
        $data = ['influe_brand_id' => $influencer_data->id, 'type' => 1];
        ScrapeTiktok::create($dataTiktok);
        ScrapeInstagram::create($data);
        ScrapeSnapchat::create($data);
    }

    public function edit($influence)
    {
        $staticData = $this->getStaticInfluencerData();
        $categories = InfluencerClassification::where('status', 'category')->get(['id', 'name']);
        $influencer = Influencer::findOrFail($influence->id);
        $nationalities = Nationality::all();
        $jobs = Job::all();
        $interests = Interest::whereStatus(1)->get();
        $languages = Language::whereStatus(1)->get();
        $socialStatus = User::getInfluencerSocialType();
        $statInflue = User::getInfluencerStatus();
        $channels = getCampaignCoverageChannels();
        // $socialMedia = $this->SelectedMeida($influence);
        $attitude = attitude();

        return view('admin.dashboard.influencers.edit', get_defined_vars());
    }

    // public function SelectedMeida($influencer)
    // {
    //     $socialMedia = [];
    //     isset($influencer) && $influencer->insta_uname != NULL ? $socialMedia['insta'] = $influencer->insta_uname : NULL;
    //     isset($influencer) && $influencer->facebook_uname != NULL ?  $socialMedia['facebook'] = $influencer->facebook_uname : NULL;
    //     isset($influencer) && $influencer->twitter_uname != NULL ?  $socialMedia['twitter'] = $influencer->twitter_uname : NULL;
    //     isset($influencer) && $influencer->snapchat_uname != NULL ?  $socialMedia['snapchat'] = $influencer->snapchat_uname : NULL;
    //     return $socialMedia;
    // }

    public function update($request, $influence)
    {
        $influencer = Influencer::findOrFail($influence->id);
        $this->generateCodes($influencer);
        $user = User::findOrFail($influence->user_id);
        $inputs = $request->except(['_token', '_method', 'user_name', 'email', 'password', 'phone_code', 'whatsapp_code', 'is_main', 'phone_type', 'phone', 'main_phone', 'main_phone_code', 'platforms', 'channel_ids']);
        $inputs['address'] = $request->address;
        // $inputs['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);
        $inputs['code_whats'] = $request->whatsapp_code;
        $inputs['has_voucher'] = $request->has_voucher;
        $inputs['attitude_id'] = $request->attitude_id;
        $inputs['licence'] = $request->licence ? 1 : 0;
        $inputs['v_by_g'] = $request->v_by_g ? 1 : 0;
        $inputs['category_ids'] = $request->category_ids;
        $inputs['coverage_channel'] = $request->channel_ids;
        if ($request->has('classification_ids')) {
            $inputs['classification_ids'] = $request->classification_ids;
        }
        $socailData=Influencer::socailMediaInputs($request->get('social', []));
        // $inputs['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);

        $newInputs = array_merge($inputs, $socailData);

        $data = ['user_name' => $request->user_name, 'email' => $request->email, 'code' => $request->main_phone_code, 'phone' => $request->main_phone];
        if ($request->has('password') && $request->password !== null) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $influencer->update($newInputs);

        if (is_array($request->phone) && is_array($request->phone_type) && is_array($request->phone_code) && count($request->phone) > 0 && count($request->phone_type) > 0 && count($request->phone_code) > 0) {
            foreach ($request->phone as $key => $dataphone) {
                $phones[] = ['influencer_id' => $influencer->id, 'code' => $request->phone_code[$key], 'phone' => $dataphone, 'type' => $request->phone_type[$key], 'is_main' => 0, 'user_type' => 1];
                $influencer->InfluencerPhones()->delete();
            }
            InfluencerPhone::insert($phones);
        }
        $children = [];
        if($influencer->ChildrenInfluencer()->count() > 0){
            $influencer->ChildrenInfluencer()->delete();
        }
        if ($request->children_num > 0 && is_array($request->childname) && count($request->childname) > 0) {
            foreach ($request->childname as $key => $child) {
                $children[] = ['influencer_id' => $influencer->id, 'child_name' => $child, 'child_gender' => isset($request->childgender[$key])?$request->childgender[$key]:"male", 'child_dob' => $request->childdob[$key] ?? "1976-01-30"];
            }
            InfluencerChild::insert($children);
        }

        return response()->json(['status' => true, 'route' => route('dashboard.influences.index'), 'message' => 'Influencer Updated successfully'], 200);
    }

    public function getInfluencer($request)
    {
        $influencers = Influencer::select('influencers.id', 'influencers.image', 'influencers.marital_status', 'influencers.whats_number', 'influencers.name', 'influencers.active', 'influencers.country_id', 'influencers.category_ids', 'influencers.gender', 'influencers.insta_uname', 'influencers.interest', 'influencers.created_at', 'influencers.user_id','users.user_name')->join('users', 'influencers.user_id', '=', 'users.id')->dtFilter($request)->distinct()->orderBy('id', 'desc');
        return DataTables::of($influencers)
            ->editColumn('name', function ($item) {
                return @$item->name;
            })
            ->addColumn('user_name', function ($item) {
                return (string) @$item->user->user_name??"--";
            })
            ->editColumn('category_ids', function ($item) {
                return @$item->Categories();
            })
            ->editColumn('active', function ($item) {
                return (int) @$item->active;
            })
            ->editColumn('interest', function ($item) {
                return implode(',', @$item->interests->pluck('interest')->toArray());
            })
            ->editColumn('insta_uname', function ($item) {
                return (string) @$item->insta_uname;
            })
            ->addColumn('bio', function ($item) {
                return (string) @$item->instagram->bio ?? '-';
            })
            ->editColumn('image', function ($item) {
                return @$item->image;
            })
            ->editColumn('country_id', function ($item) {
                return @$item->country ? $item->country->code : '';
            })
            ->editColumn('created_at', function ($item) {
                return @$item->created_at ? Carbon::parse($item->created_at)->format("Y-m-d") : '';
            })
            ->addColumn('complete_date', function ($item) {
                return (@$item->marital_status && $item->whats_number) ? "Complete" : "Not Complete";
            })
            ->addColumn('followers', function ($item) {
                return [
                    'insta' => kmb(@$item->instagram->followers) ?? 0, 'snap' => kmb(@$item->snapchat->followers) ?? 0,
                    'tiktok' => kmb(@$item->tiktok->followers) ?? 0, 'face' => kmb(@$item->facebook->followers) ?? 0,
                    'twitter' => kmb(@$item->twitter->followers) ?? 0,
                ];
            })
            ->addColumn('actions', function ($item) {
                return ['id' => $item->id];
            })->rawColumns(['bio', 'actions', 'followers', 'complete_date'])
            ->make(true);
    }

    public function getCountries()
    {
        $search = request()->search;

        if ($search == '') {
            $countries = Country::orderby('name', 'asc')->select('id', 'name')->where('active', '1')->get();
        } else {
            $countries = Country::orderby('name', 'asc')->select('id', 'name')->where('active', '1')->where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }

        return response()->json(['status' => true, 'data' => $countries], 200);
    }

    public function getGovernorate()
    {

        $country_id = request()->country_id;
        $search = request()->search;

        if ($search == '') {
            $states = State::orderby('name', 'asc')->select('id', 'name')->where('country_id', $country_id)->get();
        } else {
            $states = State::orderby('name', 'asc')->select('id', 'name')->where('country_id', $country_id)->where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }

        return response()->json(['status' => true, 'data' => $states], 200);
    }


    public function getBrand()
    {
        $search = request()->search;

        if ($search == '') {
            $brands = Brand::with('group_lists:id,name,brand_id,country_id')->where('status', 1)->get();
        } else {

            $brands = Brand::where(function ($query) use ($search) {
                $query->whereHas('group_lists')
                    ->where('status', 1)
                    ->with('group_lists:id,name,brand_id,country_id')
                    ->where('name', 'like', '%' . $search . '%')->limit(10);
            })->get();
        }

        return response()->json(['status' => true, 'data' => $brands], 200);
    }

    public function getInfluencerdata()
    {
        $id = request()->influencer;
        $influencer = Influencer::find($id);
        return response()->json(['status' => true, 'data' => $influencer], 200);
    }

    public function UpdateInfluencerdata()
    {
        $id = request()->influencer;
        $influencer = Influencer::find($id);
        if (request()->has('exprie_date') && request()->exprie_date != '') {
            $influencer->update(['expirations_date' => request()->exprie_date, 'active' => 0]);
        } else {
            $influencer->update(['expirations_date' => request()->exprie_date, 'active' => 3]);
        }

        return response()->json(['status' => true, 'id' => $influencer->id, 'data' => 'influencer Updated successfully'], 200);
    }

    public function getStatus()
    {
        $search = request()->search;

        if ($search == '') {
            $status = Status::where('type', 'influencer')->select('id', 'name')->get();
        } else {
            $status = Status::where('type', 'influencer')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }
        return response()->json(['status' => true, 'data' => $status], 200);
    }

    public function getNationalities()
    {
        $search = request()->search;

        if ($search == '') {
            $nationalities = Nationality::orderby('name', 'asc')->select('id', 'name')->get();
        } else {
            $nationalities = Nationality::orderby('name', 'asc')->select('id', 'name')->where('name', 'like', '%' . $search . '%')->limit(10)->get();
        }

        return response()->json(['status' => true, 'data' => $nationalities], 200);
    }

    public function destroy($influence)
    {
        request()->validate([
            'reason' => 'required',
        ]);

        if (request()->reason != '') {
            Influencer::findOrFail($influence->id)->update([
                'reason' => request()->reason,
            ]);
        }
        $influencer = Influencer::findOrFail($influence->id);
        if ($influencer) {
            $influencer->delete();
            $influencer->user->delete();
        }
        $statistics = $this->statictics();
        return response()->json(['status' => true, 'data' => $statistics, 'message' => 'deleted successfully'], 200);
    }

    public function import()
    {
            $import = new InfluencerImport();
            Excel::import($import, request()->file('file')->store('temp'));
            $message_success = $import->messages_success;
            return response()->json(['status' => true, 'message' => $message_success], 200);
    }

    public function export($request)
    {
        $visibleColumns = ($request->get('visibleColumns') !== null) ? array_map('strVal', explode(',', $request->get('visibleColumns'))) : [];
        $selected_ids = ($request->get('selected_ids') !== null) ? array_map('intval', explode(',', $request->get('selected_ids'))) : [];
        return Excel::download(new InfluencerExport($visibleColumns, $selected_ids, $request), 'influencers.xlsx');
    }

    public function delete_all($request)
    {
        $request->validate([
            'reason' => 'required',
        ]);

        $selected_ids_new = explode(',', $request->selected_ids);
        $influencers = Influencer::whereIn('id', $selected_ids_new)->get();
        foreach ($influencers as $influencer) {
            $influencer->update(['reason' => $request->reason]);
            $influencer->delete();
            $influencer->user()->delete();
        }
        $statistics = $this->statictics();
        return response()->json(['status' => true, 'data' => $statistics, 'message' => 'deleted successfully'], 200);
    }

    public function edit_all($request)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        $updatedData = [];
        $allIsEmpty = true;
        if (!is_null($request->input('bulk_active'))) {
            $allIsEmpty = false;
            $updatedData['active'] = ($request->bulk_active == -1) ? "0" : $request->bulk_active;
        }

        if (!is_null($request->input('bulk_status'))) {
            $allIsEmpty = false;
            $updatedData['status'] = $request->bulk_status;
        }

        if ($request->input('bulk_expirations_date')) {
            $allIsEmpty = false;
            $updatedData['expirations_date'] = $request->bulk_expirations_date;
        }

        if ($request->input('bulk_classification')) {
            $allIsEmpty = false;
            $updatedData['classification_ids'] = $request->bulk_classification;
        }

        if ($request->input('bulk_country')) {
            $allIsEmpty = false;
            $updatedData['country_id'] = $request->bulk_country;
        }

        if ($request->input('bulk_city')) {
            $allIsEmpty = false;
            $updatedData['city_id'] = $request->bulk_city;
        }

        if ($request->input('bulk_governorate')) {
            $allIsEmpty = false;
            $updatedData['state_id'] = $request->bulk_governorate;
        }

        if (!is_null($request->input('bulk_gender'))) {
            $allIsEmpty = false;
            $updatedData['gender'] = $request->bulk_gender;
        }

        if ($request->input('bulk_interests')) {
            $allIsEmpty = false;
            $updatedData['interest'] = $request->bulk_interests;
        }

        if($allIsEmpty){
            return response()->json(['status' => false, 'data' => [], 'message' => 'Please Select at least one option to update!'], 200);
        }

        Influencer::whereIn('id', $selected_ids_new)->update($updatedData);
        $statistics = $this->statictics();
        return response()->json(['status' => true, 'data' => $statistics, 'message' => 'Update successfully'], 200);
    }

    public function AddInflue_to_group($request)
    {
        //fixme::groupUpdates
        $country = is_array($request->country) ? $request->country[0] : null;
//        $arrGroupCountry = $this->groupListRepository->filterGroupCountry(!is_null($country) ? $request->country : Brand::find($request->brand_id)->country_id);
        $arrGroupCountry = [];
        $validated = $request->validate([
            'brand_id' => 'required|numeric|exists:brands,id',
            'copy_all_id' => 'required',
            'brands_groups' => 'required|array',
            'brands_groups.*' => 'required|numeric|exists:group_lists,id',
        ]);
        if ($validated) {
            $brand = Brand::find((int) $request->brand_id);
//            $subBrand = Subbrand::find((int) $request->sub_brand_id);

            $influencers = Influencer::find(explode(',', $request->copy_all_id));

            $groups = GroupList::whereIn('id', array_map('intval', $request->brands_groups))->get();
            if (empty($groups->country_id)) {
                //$groups->country_id = $arrGroupCountry;
                $groups->first()->update(['country_id' => array_map('intval', $brand->country_id)]);
            }

            $influencersDislikesIds = BrandDislike::where('brand_id', $brand->id)->whereIn('influencer_id', explode(',', $request->copy_all_id))->pluck('influencer_id')->toArray();
            $brandCountries = is_array($brand->country_id)?$brand->country_id:[];
            $message = [];
            $total_failed = 0;
            $total_success = 0;
            foreach ($groups as $group){
                foreach ($influencers as $influe) {
                    if(!in_array($influe->country_id, $brandCountries)){
                        $total_failed +=1;
                        array_push($message, ["Name" => $influe->name,"Id"=>$influe->id,'Resaon'=>__('api.influencercountry_notmatch')]);
                        continue;
                    }

                    if(!in_array((int) $influe->active, [1])){
                        $total_failed +=1;
                        array_push($message, ["Name" => $influe->name,"Id"=>$influe->id,'Resaon'=>__('api.influencer_isnot_active')]);
                        continue;
                    }

                    if(in_array($influe->id, $influencersDislikesIds)){
                        $total_failed +=1;
                        array_push($message, ["Name" => $influe->name,"Id"=>$influe->id,'Resaon'=>__('api.influencer_is_disliked')]);
                        continue;
                    }

                    InfluencerGroup::updateOrCreate([
                        'influencer_id' => (int) $influe->id,
                        'brand_id' => (int) $brand->id,
                        'source' => 'INSTAGRAM',
                        'group_list_id' => (int) $group->id,
                        'group_deleted_at' => null,
                        'deleted_at' => null,
                    ], [
                        'influencer_id' => (int) $influe->id,
                        'brand_id' => (int) $brand->id,
                        'source' => 'INSTAGRAM',
                        'group_list_id' => (int) $group->id,
                        'date' => Carbon::now(),
                        'created_by' => auth()->id(),
                    ]);
                    $total_success +=1;
                }
            }
            return [ "messages" => __('api.successfully_added') ,"results" => $message,'total_failed'=>$total_failed , 'total_success'=>$total_success ];
        }
        return ["status" => false, "messages" => 'server Error!'];
    }

    public function addGroups($groups, $influencers, $brand_id, $country)
    {

        $created_by = auth()->user()->id;
        $message = [];
        foreach ($influencers as $influe) {
            if (is_array($country) && in_array((string) $influe->country_id, $country)) {
                foreach ($groups as $group) {
                    if (in_array($influe->country_id, $group->country_id)) {
                        $res = DB::statement("UPDATE brand_favorites SET  group_list_id = IF(`group_list_id` IS NULL OR JSON_TYPE(`group_list_id`) != 'ARRAY', JSON_ARRAY(),  `group_list_id` )
                            ,group_list_id =    JSON_ARRAY_APPEND(`group_list_id` , '$',json_object('list_id','{$group->id}','created_at',NOW(),'created_by','{$created_by}','deleted_at',Null))
                            WHERE `brand_id` = '{$brand_id}' AND `influencer_id` = {$influe->id} and JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NULL;");
                        if ($res) {
                            //if yes Append
                            DB::statement("UPDATE brand_favorites SET  group_list_id = IF(`group_list_id` IS NULL OR JSON_TYPE(`group_list_id`) != 'ARRAY', JSON_ARRAY(),  `group_list_id` )
                                ,group_list_id =    JSON_ARRAY_APPEND(`group_list_id` , '$',json_object('list_id','{$group->id}','created_at',NOW(),'created_by','{$created_by}','deleted_at',Null))
                                WHERE `brand_id` = '{$group->brand_id}' AND`influencer_id` = '{$influe->id}' and JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NULL;");
                        } else {
                            array_push($message, ["group_name" => $group->name, "Name" => $influe->name, "status" => "faild", "message" => "Something went wrong."]);
                        }
                    } else {
                        $res = DB::statement("UPDATE brand_favorites SET  group_list_id = IF(`group_list_id` IS NULL OR JSON_TYPE(`group_list_id`) != 'ARRAY', JSON_ARRAY(),  `group_list_id` )
                            ,group_list_id =    JSON_ARRAY_APPEND(`group_list_id` , '$',json_object('list_id','{$group->id}','created_at',NOW(),'created_by','{$created_by}','deleted_at',Null))
                            WHERE `brand_id` = '{$brand_id}' AND `influencer_id` = {$influe->id} and JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NULL;");
                        if (!$res) {
                            array_push($message, ["group_name" => $group->name, "Name" => $influe->name, "status" => "faild", "message" => "Influence country is outside group countries"]);
                        }
                    }
                }
                array_push($message, ["status" => "success"]);
            } else {
                array_push($message, ["group_name" => 'sss', "Name" => $influe->name, "status" => "faild", "message" => "Influence country is outside company countries"]);
            }
        }
        return ["groupss" => $groups, "messages" => $message];
    }

    public function restore_all($request)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        BrandFav::whereIn('influencer_id', $selected_ids_new)->where('brand_id', $request->brand_id)->restore();
        $brand = Brand::find($request->brand_id);
        $groupsCount = [];
        foreach ($brand->group_lists as $group) {
            $sl = DB::table('brand_favorites')->select(DB::raw("count(*)as fav_count"))->whereRaw("JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NOT NULL and brand_favorites.brand_id = {$group->brand_id} and brand_favorites.`deleted_at` IS NULL")->first();
            $count_influe = $sl->fav_count;
            array_push($groupsCount, ['group_id' => $group->id, 'count' => $count_influe]);
        }
        return response()->json(['status' => true, 'message' => 'deleted successfully', 'groupsCount' => $groupsCount], 200);
    }

    public function restore_influ_dislikes($request)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        $brand = Brand::find($request->brand_id);
        $dislikes = $brand->dislikes()->whereIn('id', $selected_ids_new)->delete();
        return response()->json(['status' => true, 'message' => 'Restored successfully'], 200);
    }

    public function delete_fav_all($request)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        InfluencerGroup::whereIn('influencer_id', $selected_ids_new)->where('brand_id', $request->brand_id)->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s'), 'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        $brand = Brand::find($request->brand_id);
        $groupsCount = [];
        foreach ($brand->group_lists as $group) {
            $count_influe = InfluencerGroup::where('brand_id', $request->brand_id)->where('group_list_id', $group->id)->whereNull('group_deleted_at')->count();
            array_push($groupsCount, ['group_id' => $group->id, 'count' => $count_influe]);
        }
        return response()->json(['status' => true, 'message' => 'deleted successfully', 'groupsCount' => $groupsCount], 200);
    }

    public function getCountryState($id)
    {
        $states = State::where('country_id', $id)->select('id', 'name')->get();
        $states = $states->map(function ($state) {
            return ['id' => $state->id, 'name' => $state->name];
        });
        return response()->json(['status' => true, 'data' => $states], 200);
    }

    public function getCityState($id)
    {

        $cities = City::where('state_id', $id)->get()->pluck('name', 'id')->toArray();
        return response()->json(['status' => true, 'data' => $cities], 200);
    }

    public function getScrape($id)
    {
        $influencer = Influencer::findOrFail($id);
        $timestamp = Carbon::now()->timestamp;
        $influencer_profile_url = url('/') . '/digial_card/' . $influencer->insta_uname . '/' . $this->encrypt($influencer->influ_code) . '_' . $timestamp;

        if (!empty($influencer->insta_uname)) {
            $this->scrapInstagram($influencer);
        }

        if (!empty($influencer->snapchat_uname)) {
            $this->scrapeSnap($influencer);
        }

        if (!empty($influencer->tiktok_uname)) {
            $this->scrapInstagram($influencer);
        }

        $instagramData = $influencer->instagram;
        $tiktokdata = $influencer->tiktok;
        $snapchatData = $influencer->snapchat;

        return view('admin.dashboard.influencers.social_scrape', get_defined_vars());
    }

    public function statictics()
    {
        if (request()->has('country_id')) {
            $statistics['totalInfluencer'] = ['title' => 'Totasl Influencers', 'id' => 'Txotal_Influencer', 'value' => '-1', 'count' => Influencer::where('country_id', request('country_id'))->count(), 'icon' => 'fab fa-bandcamp'];
            $statistics['activeInfluencer'] = ['title' => 'Active Influencers', 'id' => 'Active_Influencer', 'value' => '1', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "1")->count(), 'icon' => 'fas fa-toggle-on'];
            $statistics['inactiveInfluencer'] = ['title' => 'Inactive Influencers', 'id' => 'Inactive_Influencer', 'value' => '2', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "2")->count(), 'icon' => 'fas fa-toggle-off'];
            $statistics['PendingInfluencer'] = ['title' => 'Pending Influencers', 'id' => 'Pending_Influencer', 'value' => '0', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "0")->count(), 'icon' => 'fas fa-grin-tongue'];
            $statistics['RejectInfluencer'] = ['title' => 'Rejected Influencers', 'id' => 'Reject_Influencer', 'value' => '3', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "3")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['BlockedInfluencer'] = ['title' => 'Blocked Influencers', 'id' => 'Blocked_Influencer', 'value' => '4', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "4")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['NoResponseInfluencer'] = ['title' => 'No Response Influencers', 'id' => 'No_Response_Influencer', 'value' => '5', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "5")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['OutOfCountryInfluencer'] = ['title' => 'Out Of Country Influencers', 'id' => 'out_of_country_Influencer', 'value' => '7', 'count' => Influencer::where('country_id', request('country_id'))->where('active', "7")->count(), 'icon' => 'fas fa-times-circle'];
        } else {
            $statistics['totalInfluencer'] = ['title' => 'Total Influencers', 'value' => '-1', 'class' => 'Total_Influencer', 'count' => Influencer::count(), 'icon' => 'fab fa-bandcamp'];
            $statistics['activeInfluencer'] = ['title' => 'Active Influencers', 'value' => '1', 'class' => 'Active_Influencer', 'count' => Influencer::where('active', "1")->count(), 'icon' => 'fas fa-toggle-on'];
            $statistics['inactiveInfluencer'] = ['title' => 'Inactive Influencers', 'value' => '2', 'class' => 'Inactive_Influencer', 'count' => Influencer::where('active', "2")->count(), 'icon' => 'fas fa-toggle-off'];
            $statistics['PendingInfluencer'] = ['title' => 'Pending Influencers', 'value' => '0', 'class' => 'Pending_Influencer', 'count' => Influencer::where('active', "0")->count(), 'icon' => 'fas fa-grin-tongue'];
            $statistics['RejectInfluencer'] = ['title' => 'Rejected Influencers', 'value' => '3', 'class' => 'Reject_Influencer', 'count' => Influencer::where('active', "3")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['BlockedInfluencer'] = ['title' => 'Blocked Influencers', 'value' => '4', 'class' => 'Blocked_Influencer', 'count' => Influencer::where('active', "4")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['NoResponseInfluencer'] = ['title' => 'No Response Influencers', 'value' => '5', 'class' => 'No_Response_Influencer', 'count' => Influencer::where('active', "5")->count(), 'icon' => 'fas fa-times-circle'];
            $statistics['OutOfCountryInfluencer'] = ['title' => 'Out Of Country Influencers', 'value' => '7', 'class' => 'out_of_country_Influencer', 'count' => Influencer::where('active', "7")->count(), 'icon' => 'fas fa-times-circle'];
        }
        return $statistics;
    }


    public function getBrandFavouritesQuery($brandData, $brandDislikesIds = [], $filter = [])
    {
        $brandId = $brandData->id;
        $deleted = $filter['del']??0;
        $countriesIds = is_array($brandData->country_id)?$brandData->country_id:[];
        $searchCountry = null;
        if(isset($filter['country_taps'])){
            $searchCountry = in_array((int) $filter['country_taps'], $countriesIds)?(int)$filter['country_taps']:0;
        }
        $influencersQuery = Influencer::with('user', 'influencerGroups')->where('influencers.active',1);

        if($deleted == 1){
            $influencersQuery = $influencersQuery->whereNotIn('id', $brandDislikesIds)->whereDoesntHave('influencerGroups', function ($q) use ($brandId) {
                $q->where('influencers_groups.brand_id', (int) $brandId);
                $q->whereNull('influencers_groups.deleted_at');
            });
        }else{
            $influencersQuery = $influencersQuery->whereNotIn('id', $brandDislikesIds)->whereHas('influencerGroups', function ($q) use ($deleted, $filter, $brandId) {
                $q->where('influencers_groups.brand_id', (int) $brandId);
                if($deleted == 1){
                    $q->whereNotNull('influencers_groups.deleted_at'); //fixme::old
                }else{
                    $q->whereNull('influencers_groups.deleted_at');
                }

                $q->when(array_key_exists('groupId', $filter) && $filter['groupId'] != 0 && $deleted == 0, function ($q) use ($filter) {
                    $q->where('influencers_groups.group_list_id', (int) $filter['groupId'])->whereNull('influencers_groups.group_deleted_at');
                });

                $q->when(array_key_exists('groupId', $filter) && $filter['groupId'] != 0 && $deleted == 1, function ($q) use ($filter) {
                    $q->where('influencers_groups.group_list_id', (int) $filter['groupId'])->whereNotNull('influencers_groups.group_deleted_at'); //fixme::old
                });

                $q->when(array_key_exists('groupId', $filter) && $filter['groupId'] != 0 && $deleted == 1, function ($q) use ($filter) {
                    $q->where('influencers_groups.group_list_id', (int) $filter['groupId'])->whereNotNull('influencers_groups.group_deleted_at'); //fixme::old
                });

            });
        }

        $influencersQuery = $influencersQuery->when(array_key_exists('custom', $filter) && $filter['custom'] != null, function ($q) use ($filter) {
        $q->where(function ($q2) use ($filter) {
            $q2->where('name', 'like', "%" . $filter['custom'] . "%")->orWhereHas('user', function ($q3) use ($filter) {
                $q3->where('users.user_name', 'like', "%" . $filter['custom'] . "%");
            });
        });
       })->when(array_key_exists('visited_campaign', $filter) && $filter['visited_campaign'] == '1', function ($q) use ($brandId, $filter) {
            $q->whereRaw("influencers.id in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$brandId}  and campaign_influencers.status = 2)");
        })->when(array_key_exists('visited_campaign', $filter) && $filter['visited_campaign'] == '0', function ($q) use ($brandId, $filter) {
            $q->whereRaw("influencers.id NOT in (select campaign_influencers.influencer_id from  campaign_influencers  join campaigns where campaigns.id =campaign_influencers.campaign_id and campaigns.brand_id = {$brandId} and  campaign_influencers.status = 2)");
        });

         if(!is_null($searchCountry)){
            $influencersQuery = $influencersQuery->whereIn('influencers.country_id', [$searchCountry]);
        }else{
            if(count($countriesIds) > 0){
                $influencersQuery = $influencersQuery->whereIn('influencers.country_id', $countriesIds);
            }
        }

        return $influencersQuery;
    }
}
