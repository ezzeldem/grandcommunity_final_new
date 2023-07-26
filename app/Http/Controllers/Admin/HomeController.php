<?php

namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use DateTime;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Status;
use App\Models\Country;
use App\Models\Campaign;
use App\Models\Influencer;
use App\Models\BrandCountry;
use Illuminate\Http\Request;
use App\Models\InfluencerComplain;
use App\Http\Controllers\Controller;
use App\Models\InfluencerComplainReply;
use App\Repository\StatisticsRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Admin\ComplainsResource;
use App\Http\Resources\Admin\InfluenerChartResource;
use Illuminate\Support\Facades\DB as FacadesDB;

class HomeController extends Controller
{
//     public function filterSectionsStats(Request $request){


//         $data = [];
//         //operations
//             $totalOperations =  Admin::Filter($request->all())->count();
//             $activeOperations = Admin::Filter($request->all())->where('active',1)->count();
//             $inactiveOperations =  Admin::Filter($request->all())->where('active',0)->count();
//             $data['operations']['totalOperations'] = $totalOperations;
//             $data['operations']['activeOperations'] = $activeOperations;
//             $data['operations']['inactiveOperations'] = $inactiveOperations;

//         //Influencers
//             $activeInfluencer = Influencer::seach($request)->where('active',1)->count();
//             $inactiveInfluencer = Influencer::seach($request)->where('active',0)->count();
//             $pendingInfluencer = Influencer::seach($request)->where('active',2)->count();
//             $rejectedInfluencer = Influencer::seach($request)->where('active',3)->count();
//             $totalInfluencer = Influencer::seach($request)->count();
//             $data['influencer']['activeInfluencer'] = $activeInfluencer;
//             $data['influencer']['inactiveInfluencer'] = $inactiveInfluencer;
//             $data['influencer']['pendingInfluencer'] = $pendingInfluencer;
//             $data['influencer']['rejectedInfluencer'] = $rejectedInfluencer;
//             $data['influencer']['totalInfluencer'] = $totalInfluencer;

//         //Brands
//             $activeBrand = Brand::ofDashboardFilter($request->all())->where('status',1)->count();
//             $inactiveBrand = Brand::ofDashboardFilter($request->all())->where('status',0)->count();
//             $pendingBrand = Brand::ofDashboardFilter($request->all())->where('status',2)->count();
//             $rejectedBrand = Brand::ofDashboardFilter($request->all())->where('status',3)->count();
//             $totalBrand = Brand::ofDashboardFilter($request->all())->count();
//             $data['brand']['activeBrand'] = $activeBrand;
//             $data['brand']['inactiveBrand'] = $inactiveBrand;
//             $data['brand']['pendingBrand'] = $pendingBrand;
//             $data['brand']['rejectedBrand'] = $rejectedBrand;
//             $data['brand']['totalBrand'] = $totalBrand;

//         //Campaigns
//             $counter = 0;
//             $totalCamp = Campaign::filter($request->all())->get()->each(function ($q) use (&$data,&$counter){
//                 $counter = 0;
//                 if($q->status == 0){
//                     if(isset($data['campaign']['totalCamp']['total_active'] ))
//                         $data['campaign']['totalCamp']['total_active'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_active'] = ($counter +=1);
//                 } elseif ($q->status == 1)
//                     if(isset($data['campaign']['totalCamp']['total_pending'] ))
//                         $data['campaign']['totalCamp']['total_pending'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_pending'] = ($counter +=1);
//                 elseif ($q->status == 2)
//                     if(isset($data['campaign']['totalCamp']['total_completed'] ))
//                         $data['campaign']['totalCamp']['total_completed'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_completed'] = ($counter +=1);
//                 elseif ($q->status == 3)
//                     if(isset($data['campaign']['totalCamp']['total_canceled'] ))
//                         $data['campaign']['totalCamp']['total_canceled'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_canceled'] = ($counter +=1);
//                 elseif ($q->status == 4)
//                     if(isset($data['campaign']['totalCamp']['total_confirmed'] ))
//                         $data['campaign']['totalCamp']['total_confirmed'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_confirmed'] = ($counter +=1);
//                 elseif ($q->status == 5)
//                     if(isset($data['campaign']['totalCamp']['total_onhold'] ))
//                         $data['campaign']['totalCamp']['total_onhold'] +=1;
//                     else
//                         $data['campaign']['totalCamp']['total_onhold'] = ($counter +=1);

//             })->count();

//             $visitCamp = Campaign::filter($request->all())->where('campaign_type',0)->count();
//             $deliveryCamp = Campaign::filter($request->all())->where('campaign_type',1)->count();
//             $mixCamp = Campaign::filter($request->all())->where('campaign_type',2)->count();
//             $data['campaign']['visitCamp'] = $visitCamp;
//             $data['campaign']['deliveryCamp'] = $deliveryCamp;
//             $data['campaign']['mixCamp'] = $mixCamp;
//             $data['campaign']['totals'] = $visitCamp + $deliveryCamp + $mixCamp;
// //            dd($data);


//         return response()->json(['data' => $data]);

//     }

    public function statsistisc(){


        // Admin::seclectraw('count(id) as admincount')
        $stats = [];
        $activeOperations = Admin::selectRaw('COUNT(*) AS count')->where('active', 1)->where('role','operations')->Filter(\request()->all())->pluck('count')->first();
        $stats['activeOperations'] = $activeOperations;
        $inactiveOperations =  Admin::selectRaw('COUNT(*) AS count')->where('active', 0)->where('role','operations')->Filter(\request()->all())->pluck('count')->first();
        $stats['inactiveOperations'] = $inactiveOperations;
        $totalOperations =   Admin::selectRaw('COUNT(*) AS count')->where('role','operations')->Filter(\request()->all())->pluck('count')->first();
        $stats['totalOperations'] = $totalOperations;

        $activeSales = Admin::selectRaw('COUNT(*) AS count')->where('role','sales')->where('active',1)->Filter(\request()->all())->pluck('count')->first();
        $stats['activeSales'] = $activeSales;
        $inactiveSales = Admin::Filter(\request()->all())->where('role','sales')->where('active',0)->count();
        $stats['inactiveSales'] = $inactiveSales;
        $stats['totalSales'] = Admin::where('role','sales')->count();

        $visitCamp = Campaign::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereHas('campaignCountries', function ($q2) {
                $q2->whereIn('country_id', array_map('intval', \request('header_country_id')));
            });})->where('campaign_type',"0")->whereNull('deleted_at')->count();
        $stats['visitCamp'] = $visitCamp;
        $deliveryCamp = Campaign::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereHas('campaignCountries', function ($q2) {
                $q2->whereIn('country_id', array_map('intval', \request('header_country_id')));
            });})->where('campaign_type',"1")->whereNull('deleted_at')->count();
        $stats['deliveryCamp'] = $deliveryCamp;
        $mixCamp = Campaign::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereHas('campaignCountries', function ($q2) {
                $q2->whereIn('country_id', array_map('intval', \request('header_country_id')));
            });})->where('campaign_type',"2")->whereNull('deleted_at')->count();
        $stats['mixCamp'] = $mixCamp;
        $shareCamp = Campaign::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereHas('campaignCountries', function ($q2) {
                $q2->whereIn('country_id', array_map('intval', \request('header_country_id')));
            });})->where('campaign_type',"3")->whereNull('deleted_at')->count();
        $stats['shareCamp'] = $shareCamp;
        $postCamp = Campaign::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereHas('campaignCountries', function ($q2) {
                $q2->whereIn('country_id', array_map('intval', \request('header_country_id')));
            });})->where('campaign_type',"4")->whereNull('deleted_at')->count();
        $stats['postCamp'] = $postCamp;

        $counter=0;
        $stats['totalFilters'] = [];
        $totalCamp = Campaign::filter(\request()->all())->get()->each(function ($q) use (&$stats,&$counter){
            $counter = 0;
            if($q->status == 0){
                if(isset($stats['totalFilters']['total_active'] ))
                    $stats['totalFilters']['total_active'] +=1;
                else
                    $stats['totalFilters']['total_active'] = ($counter +=1);
            } elseif ($q->status == 1)
                if(isset($stats['totalFilters']['total_pending'] ))
                    $stats['totalFilters']['total_pending'] +=1;
                else
                    $stats['totalFilters']['total_pending'] = ($counter +=1);
            elseif ($q->status == 2)
                if(isset($stats['totalFilters']['total_completed'] ))
                    $stats['totalFilters']['total_completed'] +=1;
                else
                    $stats['totalFilters']['total_completed'] = ($counter +=1);
            elseif ($q->status == 3)
                if(isset($stats['totalFilters']['total_canceled'] ))
                    $stats['totalFilters']['total_canceled'] +=1;
                else
                    $stats['totalFilters']['total_canceled'] = ($counter +=1);
            elseif ($q->status == 4)
                if(isset($stats['totalFilters']['total_confirmed'] ))
                    $stats['totalFilters']['total_confirmed'] +=1;
                else
                    $stats['totalFilters']['total_confirmed'] = ($counter +=1);
            elseif ($q->status == 5)
                if(isset($stats['totalFilters']['total_onhold'] ))
                    $stats['totalFilters']['total_onhold'] +=1;
                else
                    $stats['totalFilters']['total_onhold'] = ($counter +=1);

        })->count();
        $stats['totalCamp'] = $totalCamp;





        $activeInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',"1")->whereNull('deleted_at')->count();
        $stats['activeInfluencer'] = $activeInfluencer;
        $inactiveInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',2)->whereNull('deleted_at')->count();
        $stats['inactiveInfluencer'] = $inactiveInfluencer;
        $pendingInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',0)->whereNull('deleted_at')->count();
        $stats['pendingInfluencer'] = $pendingInfluencer;
        $rejectedInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',3)->whereNull('deleted_at')->count();
        $stats['rejectedInfluencer'] = $rejectedInfluencer;
        $blockedInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',4)->whereNull('deleted_at')->count();
        $stats['blockedInfluencer'] = $blockedInfluencer;
        $noResponseInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',5)->whereNull('deleted_at')->count();
        $stats['noResponseInfluencer'] = $noResponseInfluencer;
        $outOfCountryInfluencer = Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->where('active',7)->whereNull('deleted_at')->count();
        $stats['outOfCountryInfluencer'] = $outOfCountryInfluencer;
        $totalInfluencer =Influencer::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){$q->whereIn('country_id', request('header_country_id'));})->whereNull('deleted_at')->count();
        $stats['totalInfluencer'] = $totalInfluencer;

        $activeBrand = Brand::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereRaw('json_valid(country_id)')->where(function ($q2) {
                for ($j = 0; $j < count(\request('header_country_id')); $j++) {
                    $q2->orWhereJsonContains('country_id', \request('header_country_id')[$j]);
                }
            });})->where('status',1)->whereNull('deleted_at')->count();
        $stats['activeBrand'] = $activeBrand;
        $inactiveBrand = Brand::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereRaw('json_valid(country_id)')->where(function ($q2) {
                for ($j = 0; $j < count(\request('header_country_id')); $j++) {
                    $q2->orWhereJsonContains('country_id', \request('header_country_id')[$j]);
                }
            });})->where('status',2)->whereNull('deleted_at')->count();
        $stats['inactiveBrand'] = $inactiveBrand;
        $pendingBrand = Brand::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereRaw('json_valid(country_id)')->where(function ($q2) {
                for ($j = 0; $j < count(\request('header_country_id')); $j++) {
                    $q2->orWhereJsonContains('country_id', \request('header_country_id')[$j]);
                }
            });})->where('status',0)->whereNull('deleted_at')->count();
        $stats['pendingBrand'] = $pendingBrand;
        $rejectedBrand = Brand::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereRaw('json_valid(country_id)')->where(function ($q2) {
                for ($j = 0; $j < count(\request('header_country_id')); $j++) {
                    $q2->orWhereJsonContains('country_id', \request('header_country_id')[$j]);
                }
            });})->where('status',3)->whereNull('deleted_at')->count();
        $stats['rejectedBrand'] = $rejectedBrand;
        $totalBrand = Brand::when((is_array(\request('header_country_id')) && !empty(\request('header_country_id'))),function ($q){
            $q->whereRaw('json_valid(country_id)')->where(function ($q2) {
                for ($j = 0; $j < count(\request('header_country_id')); $j++) {
                    $q2->orWhereJsonContains('country_id', \request('header_country_id')[$j]);
                }
            });})->whereNull('deleted_at')->count();
        $stats['totalBrand'] = $totalBrand;


        return$stats;

    }
    public function index(Request $request){
        $stats = Cache::remember('admin_home_page_statistics', (60*3), function()
        {
            return $this->statsistisc();
        });

        $Newsinfluencers = Influencer::whereActive(0)->orderBy('created_at', 'desc')->take(100)->get();
        $NewsBrands = Brand::select('brands.*')->whereStatus(0)->with('countries')->orderBy('created_at', 'desc')->take(100)->get();

        return view('admin.dashboard.index', get_defined_vars());
    }

    public function getactivecamps(Request $request){
        $campaignsActive = Campaign::with('brand')->filter($request->all())->where('status',$request->type)->get();
        return response()->json(['data' => $campaignsActive,'typeCamp'=>$request->type]);
    }


    public function getComplains(Request $request){
        $complains = ComplainsResource::collection(InfluencerComplain::all());
        return datatables($complains)->make(true);
    }

    public function addReply(Request $request){
        $inputs = [
            'complain_reply_id'=>$request->complain_id,
            'reply_text'=>$request->reply,
            'user_id'=>auth()->user()->id,
        ];

        $complainReply =InfluencerComplainReply::create($inputs);
        $complainReply['admin'] = $complainReply->admin;
        return response()->json(['status'=> true,'alert' => [
            'icon'=>'success',
            'text'=>'Added Successfully'
        ]]);
    }

    public function update_complain_status(Request $request){
        $comp = InfluencerComplain::find($request->complain_id)->update(array_merge(['status'=>$request->status]));
        return response()->json(['status'=>true]);
    }

    public function getRecentUsers(){
        $tableType = \request()->get('tableType');
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
            $users = User::ofDashboardFilter(\request())->where('type',$tableType)->orderBy('id','desc')->get();
            $users->map(function($user){
                $user_data = ($user->influencers) ? $user->influencers : $user->brands;
                $user['type'] = $user['type']?'influencer':'brand';
                $user['phone'] = $user['code'].$user['phone'];
                $user['image'] = $user['type']?$user_data->image??'':$user_data->image??'';
                $user['user_data'] = $user_data;
                if($user['type'] == 'influencer'){
                    $user['user_data']['type'] = 'influencer';
                    if($user_data['whats_number'] && $user_data['social_type'] && $user_data['insta_uname']){
                        $user['user_data']['complete'] = 'Completed';
                    }else{
                        $user['user_data']['complete'] = 'Un Completed';
                    }
                }else{
                    $user['user_data']['type'] = 'brand';
                    if($user_data['whatsapp'] && $user_data['insta_uname']){
                        $user['user_data']['complete'] = 'Completed';
                    }else{
                        $user['user_data']['complete'] = 'Un Completed';
                    }
                }
            });
            return datatables($users)->make(true);
        }else{
            return \response()->json(['status'=>false,'message'=>'unauthenticated'],401);
        }
    }

    public function getBrandCountry($id){
        $user = User::find($id);
        $brand = $user->brands;
        $countries = $brand->countries->pluck('id');
        return response()->json(['countries' => $countries, 'brand' => $brand]);
    }


    public function viewUser(User $user){
//        $influRequiredData = ['country_id', 'insta_uname', 'image', 'nationality', 'gender', 'date_of_birth', 'lang', 'whats_number'];
//        $brandRequiredData = ['country_id', 'insta_uname', 'image', 'whatsapp', 'branches'];
        $completedData = ($user->type == 1 ) ? $user->influencers()->first() : $user->brands()->first();
        $completedData['percentage'] = 0;
        return view('admin.dashboard.users.view',compact('user', 'completedData'));
    }

    public function acceptUser(User $user,$expire_date){
        if($user->influencers()->exists())
        {
            if($expire_date != -1){
                $updated_data = ['active'=>1,'expirations_date'=>$expire_date];
                $validator = Validator::make($updated_data, [
                    'expirations_date' => [
                        'after:today'
                    ]
                ]);
                if($validator->fails()){
                    return response()->json(['status'=>false,'message'=>$validator->errors()],200);
                }
            }else{
                $updated_data = ['active'=>1];
            }
            $updated_data['influ_code']=generateRandomCode();
            $updated_data['qrcode']=generateQrcode($user, $user->influencers()->first()->country->name);

                $user->influencers()->update($updated_data);
        }elseif ($user->brands()->exists())
        {
            $brand_countries =  $user->brands()->first()->brand_countries()->pluck('country_id');
            if($expire_date != -1 ){
                $updated_data = ['status'=>1,'expirations_date'=>$expire_date];
                $validator = Validator::make($updated_data, [
                    'expirations_date' => [
                        'after:today'
                    ]
                ]);

                if($validator->fails()){
                    return response()->json(['status'=>false,'message'=>$validator->errors()],200);
                }


            }else{
                $updated_data = ['status'=>1];
            }
            $this->brandCountryCheck($brand_countries, request('brand_countries'), $user->brands()->first());
            $updated_data['country_id'] = request('brand_countries');

            if($user->brands->subbrands()->exists()){$user->brands->subbrands()->update(['status'=>1]);}
            if($user->brands->branchs()->exists()){$user->brands->branchs()->update(['status'=>1]);}
            $user->brands()->update($updated_data);
       }
       return response()->json(['status'=>true,'stats'=>$this->statsistisc(),'message'=>__('accept successfully')]);
    }

    public function brandCountryCheck($brand_countries, $countries, $brand){
        if(count($brand_countries) == 0 && $countries != -1 && !is_null($countries) && count($countries) != 0){
            foreach($countries as $country_id){
                $data = [
                    'brand_id' => $brand->id,
                    'country_id' => $country_id,
                    'created_by' => auth()->user()->id,
                    'status' =>  1
                ];
                BrandCountry::create($data);
            }
        }else{
            foreach($countries as $country_id){
                if(!in_array($country_id, $brand_countries->toArray())){
                    $data = [
                        'brand_id' => $brand->id,
                        'country_id' => $country_id,
                        'created_by' => auth()->user()->id,
                        'status' => 1,
                    ];
                    BrandCountry::Create($data);
                }else{
                    $brandCountries = BrandCountry::where('brand_id', $brand->id)->get();
                    $brandCountries->map(function($brandCountry) use ($countries){
                        return $brandCountry->update([
                            'status' => in_array($brandCountry->country_id, $countries) ? 1 : 0
                        ]);
                    });
                }
            }
        }
    }

    public function rejectUser(User $user){

        if($user->influencers()->exists()){
            $user->influencers()->delete();
            $user->delete();
        }elseif ($user->brands()->exists()){

            $brandHasCamp=$user->brands()->whereHas('campaigns',function ($q){
                $q->where('campaigns.status',0);
            });
            $subbrand_camps=$user->brands()->whereHas('subbrands.campaigns',function ($q){
                $q->where('campaigns.status',0);
            });
            if(!$brandHasCamp->exists() && !$subbrand_camps->exists()){
                $user->brands->subbrands()->delete();
                $user->brands()->with('subbrands.branches')->delete();
                $user->brands->branchs()->delete();
                $user->brands()->delete();
                $user->delete();
            }else{
                return response()->json(['status'=>false,'message'=>'can not deleted']);
            }

        }

        return response()->json(['status'=>true,'stats'=>$this->statsistisc(),'message'=>__('reject successfully')]);
    }

    public function forcerejecttUser(User $user){
        if($user->influencers()->exists()){
            $user->influencers()->update(['active'=>3]);
        }
        elseif ($user->brands()->exists()){
            $user->brands()->update(['status'=>3]);
            if($user->brands->subbrands()->exists()){$user->brands->subbrands()->update(['status'=>'0']);}
            if($user->brands->branchs()->exists()){$user->brands->branchs()->update(['status'=>'0']);}
        }
        return response()->json(['status'=>true,'stats'=>$this->statsistisc(),'message'=>'Rejected Successfully']);
    }

    public function inactiveUser(User $user){
        if($user->influencers()->exists()){
            $user->influencers()->update(['active'=>0]);
        }
        elseif ($user->brands()->exists()){
            $user->brands()->update(['status'=>0]);
            if($user->brands->subbrands()->exists()){$user->brands->subbrands()->update(['status'=>'0']);}
            if($user->brands->branchs()->exists()){$user->brands->branchs()->update(['status'=>'0']);}
        }
        return response()->json(['status'=>true,'stats'=>$this->statsistisc(),'message'=>'In Activated Successfully']);
    }

    public function activeCampaign(Campaign $campaign){
       if($campaign->status != 0){
           return redirect()->route('dashboard.index')->with('successful_message',__('campaign status active'));
       }else{
           return redirect()->route('dashboard.index')->with('error_message',__('can not change status'));
       }
    }

    public function deleteCampaign(Campaign $campaign){
       if($campaign->status == 1){
//           $campaign->delete();
           return redirect()->route('dashboard.index')->with('successful_message',__('campaign deleted successfully'));
       }else{
           return redirect()->route('dashboard.index')->with('error_message',__('can not deleted campaign'));
       }
    }

    public function editprofile(){
      $user = auth()->user();
      return view('admin.dashboard.admins.profile',compact('user'));
    }

    public function countryFlag($id){
        $countryCode = Country::find($id);
        return $countryCode->code;
    }

    public function updateprofile(Request $request){
        $admin = Admin::find($request->id);

        $validated = $request->validate([
            'name' => 'required',
            'user_name' => 'required|unique:admins,username,'.$admin->id,
            'email' => 'email|unique:admins,email,'.$admin->id,
            'password' => 'nullable|string|min:6',
            'image'=>'nullable|mimes:jpg,bmp,png',
        ]);

        if($validated){
            $admin->update($request->except('_token'));
            return redirect()->back();
        }else{
            return 'debug message';
        }

    }

    function getChartsData(Request $request){

        $statistics = new StatisticsRepository();
        $type = $request->type;
        $status = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date;


        switch($type){
            case "campaign":
               $result = $statistics->getModelSatistics(new Campaign,['start_date' =>$start_date ,'end_date'=>$end_date ],$status);
                return ['type'=>'campaign','result'=>$result];
            break;
            case "Influencer":
                $result = $statistics->getModelSatistics(new Influencer,['start_date' =>$start_date ,'end_date'=>$end_date ],$status);
                return  ['type'=>'Influencer','result'=>$result];
            break;
            case "brand":
                $result = $statistics->getModelSatistics(new Brand,['start_date' =>$start_date ,'end_date'=>$end_date ],$status);
                return  ['type'=>'brand','result'=>$result];
            break;
            default:
            break;
         }


         return $data;
    }

}
