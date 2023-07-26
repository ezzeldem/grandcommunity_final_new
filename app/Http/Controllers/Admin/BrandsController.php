<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BranchExport;
use App\Exports\BrandExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Requests\Admin\SubBrandRequest;
use App\Http\Resources\Admin\BranchResource;
use App\Http\Resources\Admin\CampaignResource;
use App\Http\Resources\Admin\DislikeResource;
use App\Http\Services\CampaignService;
use App\Imports\BrandImport;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\CampaignInfluencer;
use App\Models\Country;
use App\Http\Services\Eloquent\Campaign as CustomModel;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Models\Status;
use App\Models\Subbrand;
use App\Models\User;
use App\Repository\GroupListRepository;
use App\Repository\InfluencerRepository;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\Admin\SubBrandResource;
use App\Imports\DislikeImport;
use App\Models\BrandCountry;
use App\Models\BrandDislike;
use App\Models\InfluencerPhone;
use App\Models\Office;
use App\Repository\StaticDataInfluencerRepository;

class BrandsController extends Controller
{
    public $campaignService;
    public $group;
    public $customModel;
    public $items = [];
    public $staticInfluencerData;
    public $influencer;

    function __construct(StaticDataInfluencerRepository $staticInfluencerData, GroupListRepository $group, InfluencerRepository $influencer)
    {
        $this->staticInfluencerData = $staticInfluencerData;
        $this->customModel = new CustomModel();
        $this->campaignService = new CampaignService($this->customModel);
        $this->group = $group;
        $this->influencer = $influencer;
        $this->middleware('permission:read brands|create brands|update brands|delete brands', ['only' => ['index','show','export']]);
        $this->middleware('permission:create brands', ['only' => ['create','store','import']]);
        $this->middleware('permission:update brands', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete brands', ['only' => ['destroy','delete_all']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filterBrandStatus = request()->status ?? '';
        $statistics=$this->statictics();
        $campaign_status = Status::select('name','value')->where('type','campaign')->get();
        return view('admin.dashboard.brands.index',compact('statistics','campaign_status','filterBrandStatus'));
    }

    public function getBrand(Request $request)
    {
        \request()->only(['status_val','country_val','profile_completed_val','lastest_collaboration_search','status_id_search','startDateSearch','endDateSearch','camp_val','custom']);
		$brands = Brand::select('brands.id','brands.expirations_date', 'brands.whatsapp','brands.status','brands.insta_uname','brands.created_at','brands.user_id','brands.country_id','brands.step','users.user_name')->join('users', 'brands.user_id', '=', 'users.id')->ofFilter($request);

        return DataTables::of($brands)->editColumn('user_name',function($item){return (string)@$item->user->user_name; })
						   ->addColumn('email',function($item){ return (string)@$item->user->email; })
						   ->addColumn('campaigns_count',function($item){return  ['total' => $item->campaigns->count()];})
						   ->addColumn('group_of_brands',function($item){return   $item->subbrands->count();})
						   ->editColumn('country_id',function($item){ return ($item->country_id) ?Country::select('name','code','id')->whereIn('id', array_map('intval', $item->country_id))->get()->toArray() : ''; })
						   ->editColumn('expirations_date',function($item){ return @$item->ExpirationsDate; })
						   ->editColumn('created_at',function($item){ return @$item->created_at ? Carbon::parse($item->created_at)->format("Y-m-d") :''; })
						   ->addColumn('complete',function($item){ return ($item->whatsapp && !empty($item->country_id))?1:0;})
						   ->addColumn('actions',function($item){ return ['id' => $item->id];})->rawColumns(['actions','complete'])
			               ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        $countries_id=Country::select('id','name','code')->whereIn('id', array_map('intval', $brand->country_id??[]))->get();
        $groups = [];
        $ungroups =[];
		/*   $groups=GroupList::where('brand_id',$id)->paginate(20);
        $ungroups=GroupList::where('brand_id',$id)->onlyTrashed()->paginate(20);

        foreach ($groups as $group){
            $group['country']=implode(',',$group->country_id);
            $group['country_id'] = Country::whereIn('id', array_map('intval',$group['country_id']))->select('id','code','name')->get();
            $sl= DB::table('brand_favorites')->select(DB::raw("count(*)as fav_count"))->whereRaw("JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NOT NULL And JSON_CONTAINS(`brand_favorites`.`group_list_id`, json_object('list_id','{$group->id}','deleted_at',null)) and brand_favorites.brand_id = {$group->brand_id} and brand_favorites.`deleted_at` IS NULL")->first();
            $group['count_influe']=$sl->fav_count;
        }
        foreach ($ungroups as $group){
            $group['country_id'] = Country::whereIn('id', array_map('intval',$group['country_id']))->select('id','code','name')->get();
            $sl= DB::table('brand_favorites')->select(DB::raw("count(*)as fav_count"))->whereRaw("JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NOT NULL And JSON_CONTAINS(`brand_favorites`.`group_list_id`, json_object('list_id','{$group->id}','deleted_at',!null))  and brand_favorites.brand_id = {$group->brand_id} and brand_favorites.`deleted_at` IS NULL")->first();
            $group['count_influe']=$sl->fav_count;
        }
*/
        $camp_status = $this->campaignService->getStatus();
        $camp_types = campaignType();
         $brands=[];
		 //Brand::where('id','!=',$brand->id)->select('id','name','country_id')->get();
            return view('admin.dashboard.brands.show', compact('brand', 'camp_status', 'camp_types', 'groups', 'ungroups','brands', 'countries_id'));

    }

	protected function drawBrandAjax($id)
    {
        $newData= '';
            $imgTemp = '';
            $selectAppend='';
            if(request()->input('search') != null || request()->input('search') != ''){$flag=2;}elseif(request()->input('search') ==null && \request()->page==1){$flag=3;}else{$flag=1;}
            $groupss=GroupList::where('brand_id',$id)->where('name', 'like', '%' . request()->input('search') . '%')->paginate(20);
            foreach ($groupss as $group){
                $group['country_id'] = Country::whereIn('id', array_map('intval',$group['country_id']))->select('id','code','name')->get();
            }
            foreach ($groupss as $group){
                foreach ($group->country_id as $con){

                    $imgTemp .= '<img style="margin-left: 2px; display: inline-block; width: 22px !important;height: 22px !important;" src="https://hatscripts.github.io/circle-flags/flags/'.strtolower($con['code']).'.svg" width="26" class="img-flag" />';
                }
                $sl= DB::table('brand_favorites')->select(DB::raw("count(*)as fav_count"))->whereRaw("JSON_SEARCH( `group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NOT NULL and brand_favorites.brand_id = {$group->brand_id} and brand_favorites.`deleted_at` IS NULL")->first();
                $count_influe=$sl->fav_count;
                $new_country = json_encode($group->country_id);
                $newData .=" <div class='group-details new_data' attr-id='".$group->id."' id='item-".$group->id."'>
                                          <div class='row' >
                                                <span class='col'><input type='checkbox' value='".$group->id."' class='box1'></span>
                                                <span class='col fav_name'>".$group->name."</span>
                                                <span class='col fav_symbol'> <span style='border-radius: 50%;display: block;height: 17px;width: 17px;background:".$group->color."'></span></span>
                                                <span class='col fav_country' attr-code='".($new_country)."'>".$imgTemp."</span>
                                                    <span class='col fav_count'> <span class='badge badge-pill badge-danger'>{$count_influe}</span></span>
                                            </div>
                               </div>";
                $selectAppend.='<option class="myoptionvalue" value="'.$group->id.'">'.$group->name.'</option>';
                $imgTemp='';
            }
            return ['newData'=>$newData,'selectData'=>$selectAppend,'flag'=>$flag];
	}

    public function getBrandBranches($id,Request $request)
    {
        if(isset($request->url) && !is_null($request->url) && $request->url == 'groups'){
            $subbrand = Subbrand::find($request->sub_brand_id);
            $filter = \request()->only(['status_val','country_val','start_date','end_date','brand_val','subbrand_val','city_val']);
            $query = $subbrand->branches()->where('brand_id',$id)->ofFilterBrand($filter)->orderBy('id','desc')->get();
        }else{
            $query = Branch::where('brand_id',$id)->ofFilterBrand($request)->orderBy('id','desc')->get();
            foreach ($query as $b){
                $b['active_data'] =['id'=>$b->id,'active'=>$b->status];
            }
        }

        $data = BranchResource::collection($query);

        return Datatables::of($data)->make(true);

    }

    public function getBrandCampaigns($id,Request $request){
        if(isset($request->url) && !is_null($request->url) && $request->url == 'groups'){
            $subbrand = Subbrand::find($request->sub_brand_id);
            $filter = $request->only(['status_val', 'country_val','campaign_type_val', 'start_date', 'end_date']);
            $query = $subbrand->campaigns()->where('brand_id',$id)->ofFilterCamp($filter)->get();
        }else{
            $query = Campaign::where('brand_id',$id)->ofFilterCamp($request)->get();
        }
        $data = CampaignResource::collection($query);
        return Datatables::of($data)->make(true);
    }

    public function addNewBranch(Request $request){
        $request['name'] = $request['branch_name'];
        $name_validation = '';
        if($request['branch_id']){
            $name_validation = Rule::unique('branches')->ignore($request['branch_id']);
        }else{
            $name_validation = Rule::unique('branches')->where(function ($query) {
                return $query->whereNull('deleted_at');
            });
        }

        $validated = $request->validate([
            'name' => $name_validation,
        ]);

        if($request->branch_id){
            $branch_data = Branch::find($request->branch_id);
            if($branch_data){
                $inputs = [
                    'name' => $request->name,
                    'city' => $request->branch_city,
                    'state' => $request->branch_state,
                    'country_id' => $request->branch_country,
                    'status' => $request->branch_status,
                    'brand_id' => $request->brand_id,
                    'subbrand_id' => $request->sub_brand_id,
                    'address' => $request->address,
                ];
                if($request->subbrannd_id || $request->sub_brand_id){
                    $inputs['subbrand_id'] = $request->subbrannd_id ?? $request->sub_brand_id;
                }
                $branch_data->update($inputs);
                return redirect()->back()->with(['successful_message' => 'Branch Updated successfully']);
            }
        }else{
            if($request->brand_id != 0){
                $brand = Brand::find($request->brand_id);
            }else{
                $subbrand = Subbrand::find($request->sub_brand_id);
            }

            if(isset($brand) || isset($subbrand)){
                $inputs = [
                    'name' => $request->name,
                    'city' => $request->branch_city,
                    'state' => $request->branch_state,
                    'country_id' => $request->branch_country,
                    'status' => $request->branch_status,
                    'brand_id' => $request->brand_id,
                    'subbrand_id' => $request->sub_brand_id,
                    'address' => $request->address,
                ];
                if($request->subbrannd_id || $request->sub_brand_id){
                    $inputs['subbrand_id'] = $request->subbrannd_id ?? $request->sub_brand_id;
                }
                Branch::create($inputs);
                return response()->json(['status'=>true,'stat'=>staticticsProfilePage(isset($brand) != 0 ? $brand->id : $subbrand->id),'message'=>'Branch Add Successfully'],200);
            }
        }

    }

    public function getBrandGroups(Request $request, $id){
        //fixme::groupUpdates
		$brand = Brand::find($id);
		$type = $request->type;
		$sub_brand_id = isset($request->sub_brand_id) ? $request->sub_brand_id : 0;
		$search = isset($request->search) &&!empty($request->search) ? $request->search : null;
        $countriesIds = is_array($brand->country_id)?$brand->country_id:[];

        $dislikesIds = BrandDislike::where('brand_id', $id)->pluck('influencer_id')->toArray();
        $groups = $this->group->getGroupListsWithInfluencersCountQuery($brand->id, $countriesIds, []);


        if($sub_brand_id){
            $groups->where('group_lists.sub_brand_id', $sub_brand_id);
        }

        $filter = ['name' => $search, 'country_id' => $countriesIds];

		if($type == "fav"){
                $groups= $groups->offilter($filter)->orderBy('group_lists.id', 'desc')->get();
		}else{
		        $groups= $groups->onlyTrashed()->get();
		}

        $totalFav = Influencer::whereNotIn('influencers.id', $dislikesIds)->where('influencers.active',1)->whereHas('influencerGroups', function ($q) use ($request, $brand) {
            $q->where('influencers_groups.brand_id', $brand->id)->whereNull('influencers_groups.deleted_at');
        });

		if(count($countriesIds) > 0){
            $totalFav = $totalFav->whereIn('influencers.country_id', $countriesIds);
        }

		$totalFav = $totalFav->count();

//            $totalFav = DB::table(DB::raw("({$influencerGroupQuery->toSql()}) as query"))->mergeBindings($influencerGroupQuery->getQuery())->count();
        foreach ($groups as $group){
          //  $group['country']=implode(',',$group->country_id);
            $group['country_id'] = Country::whereIn('id', array_map('intval',(array)$group['country_id']))->select('id','code','name')->get();
//            $totalFav += (int) $group->influencer_count;
            $group['count_influe']= (int) $group->influencer_count;
        }

       return response()->json(['status'=>false,'totalFav'=>$totalFav,'groups'=>$groups]);


    }

    public function groupListBrand(Request $request)
    {
        $limit = (request('length')) ? (request('length') != "-1" ? request('length') : "5000" ) : 20;

        $start = \request('start');
        $query= $this->group->groupListBrand();

        //$count =Influencer::whereHas('brands',function ($q) use($request){
        //    $q->where('brands.id',(int)$request->brand_id);
        //    })->count();

        $count =Influencer::whereHas('brands',function ($q) use($request){
            $q->where('brands.id',(int)$request->brand_id);
            })->count();

        return Datatables::of($query)->setOffset($start)->with(['recordsTotal'=>$count, "recordsFiltered" => Influencer::ofGroupFilter($request->all())->count(),'start' => $start])->make(true);
    }

    public function deleteBrandBranch_new($id)
    {
        $branches = Branch::WhereHas('campaigns',function ($q){ $q->where('campaigns.status',0);})->where('id',$id);
        if(!$branches->exists()){
            Branch::where('id',$id)->delete();
            return response()->json(['status'=>true,'stat'=>staticticsProfilePage(\request('brand_id')),'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Can not Deleted , As Branch Contains active Campaign'],200);
    }

    public function getStaticInfluencerData(){
        $data = [
            'typePhone' => $this->staticInfluencerData->getTypePhone(),
        ];
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staticData = $this->getStaticInfluencerData();
        $countries = Country::select('id','name')->get();
        $countriesInSubBrands = [];
        return view('admin.dashboard.brands.create',compact('countries','staticData', 'countriesInSubBrands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $inputs = $request->except([/*'branches',*/'user_name','email','password']);
        $inputs['status'] = (int)$inputs['status'];
        $inputs['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);
        $user=User::create(['user_name'=>$request->user_name,'email'=>$request->email,'password'=>$request->password,'type'=>0,'phone'=>$request->main_phone,'code'=>$request->main_phone_code]);
        $inputs['user_id'] = $user->id;


        $socailData=Influencer::socailMediaInputs($inputs['social']);
		$newInputs=array_merge($inputs,$socailData);

        $brand = Brand::create($newInputs);
        $phones = [];
        if (is_array($request->phone) && is_array($request->phone_type) && is_array($request->phone_code) && count($request->phone) > 0 && count($request->phone_type) > 0 && count($request->phone_code) > 0) {
            foreach ($request->phone as $key => $dataphone) {
                if(!isset($request->phone_code[$key]) || !isset($request->phone_type[$key]) ){
                    continue;
                }

                if(!$request->phone_code[$key] || !$request->phone_type[$key] ||  !$dataphone){
                    continue;
                }

                $phones[] = ['influencer_id' => $brand->id, 'code' => $request->phone_code[$key], 'phone' => $dataphone, 'type' => $request->phone_type[$key], 'is_main' => 0, 'user_type' => 0];
                $brand->InfluencerPhones()->delete();
            }
        }

        if(count($phones) > 0){
            InfluencerPhone::insert($phones);
        }

        if(request()->has('country_id') && count(request('country_id')) > 0)
        createbrandCountries($inputs['country_id'],$brand->id,$status=1);
//        $brand_id = $brand->id;
//        $branches =json_decode($request['branches']);
//        foreach ($branches as $branch){
//            Branch::create([
//                'name' => $branch->branch_name,
//                'status' => (int)$branch->branch_status,
//                'city' => $branch->branch_city,
//                'country_id' => $branch->branch_country,
//                'subbrand_id' => 0,
//                'brand_id' => $brand_id,
//            ]);
//        }
        return response()->json(['status'=>true,'route'=>route('dashboard.brands.show',$brand->id),'message'=>'Brand Stored Successfully'],200);
    }


    public function getCampaigns(Request $request, $id){
        $subbrand = Subbrand::find($id);
        $filter = $request->only(['status_val', 'country_val','campaign_type_val', 'start_date', 'end_date', 'status_type']);
        $query = $subbrand->campaigns()->where('brand_id',$id)->ofFilterCamp($filter)->get();
        $campaigns = CampaignResource::collection( $query);
        return datatables($campaigns)->make(true);
    }

    public function getBranches(Request $request, $id){
        $subbrand = Subbrand::find($id);
        $filter = \request()->only(['status_val','country_val','start_date','end_date','brand_val','subbrand_val','city_val']);
        $branches = BranchResource::collection($subbrand->branches()->get());
        return datatables($branches)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staticData = $this->getStaticInfluencerData();
        $brand = Brand::findOrFail($id);
//        $brand['user_name'] = $brand->user->user_name;
//        $brand['email'] = $brand->user->email;
        $offices = Office::whereStatus(1)->get();
        $countries = Country::select('id','name')->get();
        $countriesInSubBrands = [];
        foreach ($brand->subbrands as $brandRow){
            $countriesInSubBrands = array_merge($countriesInSubBrands, array_values($brandRow->country_id));
        }
        $countriesInSubBrands = array_map('intval', $countriesInSubBrands);

        return view('admin.dashboard.brands.edit',compact('brand',/*'branches',*/'countries', 'offices', 'staticData', 'countriesInSubBrands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::with('branchs')->find($id);
        $inputs = $request->except([/*'branches',*/'email','status','user_name','password','address']);

        $inputs['phone'] = mergeCodeWithPhone($request->phone_code, $request->phone);

        if($request->has('password') && $request->password != null){
            $password = Hash::make($request->password);
            User::where('id', $request->user_id)
                ->update([
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'password' => $password,
                    'phone'=>$request->main_phone,
                    'code'=>$request->main_phone_code,
                ]);
        }else{
            User::where('id', $request->user_id)
                ->update([
                    'user_name' => $request->user_name,
                    'email' => $request->email,
                    'phone'=>$request->main_phone,
                    'code'=>$request->main_phone_code,
                ]);
        }
        if($request->has('status')){
            $brand->update(['status'=>$request->status, 'phone'=>$request->main_phone, 'code'=>$request->main_phone_code]);
            //Check Brand Countries Table & Update Data  For Brand
            $home = new HomeController;
            $home->brandCountryCheck($brand->brand_countries->pluck('country_id'), request('country_id'), $brand);
            if($request->status==0||$request->status==2 ||$request->status==3){
                if($brand->subbrands()->exists()){$brand->subbrands()->update(['status'=>'0']);}
                if($brand->branchs()->exists()){$brand->branchs()->update(['status'=>'0']);}
            }else{
                if($brand->subbrands()->exists()){$brand->subbrands()->update(['status'=>'1']);}
                if($brand->branchs()->exists()){$brand->branchs()->update(['status'=>'1']);}
            }
        }

        $socailData=Influencer::socailMediaInputs($inputs['social']);
		$newInputs=array_merge($inputs,$socailData);

        $brand->update($newInputs);
        $phones = [];
        if (is_array($request->phone) && is_array($request->phone_type) && is_array($request->phone_code) && count($request->phone) > 0 && count($request->phone_type) > 0 && count($request->phone_code) > 0) {
            foreach ($request->phone as $key => $dataphone) {
                if(!isset($request->phone_code[$key]) || !isset($request->phone_type[$key]) ){
                    continue;
                }

                if(!$request->phone_code[$key] || !$request->phone_type[$key] ||  !$dataphone){
                    continue;
                }

                $phones[] = ['influencer_id' => $brand->id, 'code' => $request->phone_code[$key], 'phone' => $dataphone, 'type' => $request->phone_type[$key], 'is_main' => 0, 'user_type' => 0];
                $brand->InfluencerPhones()->delete();
            }
        }

        if(count($phones) > 0){
            InfluencerPhone::insert($phones);
        }

//        $brand_id = $brand->id;
//        $branches =json_decode($request['branches']);

//        $branchesIds = [];
//        foreach ($branches as $key=>$branch){
//            if(isset($branch->brand_id)){
//                DB::table('branches')->where('id',$branch->id)->where('brand_id',$branch->brand_id)->update([
//                    'name' => $branch->name,
//                    'status' => (int)$branch->status,
//                    'city' => $branch->city,
//                    'country_id' => $branch->country_id,
//                ]);
//            }else{
//                $branch = Branch::create([
//                    'name' => $branch->name,
//                    'status' => (int)$branch->status,
//                    'city' => $branch->city,
//                    'country_id' => $branch->country_id,
//                    'subbrand_id' => 0,
//                    'brand_id' => $brand_id,
//                ]);
//            }
//            $branchesIds[$key] = $branch->id;
//
//        }
//        Branch::whereNotIn('id',$branchesIds)->where('brand_id',$brand_id)->delete();
        return response()->json(['status'=>true,'route'=>route('dashboard.brands.show',$brand->id),'message'=>'Brand Updated Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::where('id',$id)->first();
        if($brand){

            $brand_campagns = $brand->campaigns()->where('status',1)->get();

            $subbrand_camps = $brand->subbrands()->whereHas('campaigns',function($q){
                $q->where('status',1);
            })->get();

            if(count($brand_campagns) > 0 || count($subbrand_camps) > 0){
                return response()->json(['status'=>true,'message'=>'can not delete','flag'=>-1],200);
            }else{
                $brand->branchs()->delete();
                $brand->subbrands()->delete();
                $brand->delete();
                $brand->user->delete();
            }
        }
        return response()->json(['status'=>true,'message'=>'deleted successfully','flag'=>1],200);
    }

    public function import(){
        try{
            DB::beginTransaction();
            Excel::import(new BrandImport(),request()->file('file')->store('temp'));
            return redirect()->route('dashboard.brands.index')->with(['successful_message' => 'Brands Imported successfully']);
        }catch ( ValidationException $e ){
            DB::rollBack();
            return back()->withErrors($e->errors());
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            session()->flash('alert-message', 'Error! Please check if excel file has correct data');
            return back();
        }

    }

    public function dislikesImport(){
        try{
            Excel::import(new DislikeImport(request()->brand_id),request()->file('file')->store('temp'));
            return redirect()->route('dashboard.brands.index')->with(['successful_message' => 'Brands Imported successfully']);
        }catch ( ValidationException $e ){
            return back()->withErrors($e->errors());
        }

    }

    public function addToFavourites(Request $request){
        $brandId = $request->brand;
        $dislikesIds = BrandDislike::where('brand_id', $brandId)->pluck('influencer_id')->toArray();
        $influencers = Influencer::whereIn('id', $request->get('influencers'))->get();
        $authId = auth()->id();
        foreach ($influencers as $influencer){
            if(in_array((int) $brandId, $dislikesIds)){
                continue;
            }
            InfluencerGroup::updateOrCreate(['brand_id' => $brandId, 'influencer_id' => $influencer->id, 'group_list_id' => null, 'deleted_at' => null, 'group_deleted_at' => null], ['brand_id' => $brandId, 'influencer_id' => $influencer->id, 'date'=>now()->format('Y-m-d'), 'created_by' => $authId]);
        }
        return response()->json(['status'=>true,'message'=>'Saved successfully!'],200);
    }

    public function brand_subbrand_add(SubBrandRequest $request){

        $inputs = $request->except(['_token']);
        $inputs['name'] = $request['subbrand_name'];
        $inputs['status'] = $request['subbrand_status'];
        Subbrand::create($inputs);
        return redirect()->back()->with(['successful_message' => 'Sub-brand Created successfully']);
    }

    public function delete_all(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);

        $brandsCamps = Brand::whereHas('campaigns',function($q){
            $q->where('campaigns.status',1);
        })->whereIn('id',$selected_ids_new);

        $subbrand_camps = Brand::whereHas('subbrands.campaigns',function ($q){
            $q->where('campaigns.status',1);
        })->whereIn('id',$selected_ids_new);

        if(!$brandsCamps->exists() && !$subbrand_camps->exists()){
            $brands= Brand::whereIn('id',$selected_ids_new)->get();
           foreach ($brands as $brand) {
               if ($brand) {
                   $brand->branchs()->delete();
                   $brand->subbrands()->delete();
                   $brand->user->delete();
                   $brand->delete();
               }
           }
            return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'can not Deleted'],200);
        }

    }

    public function branches_all_delete_all(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);
        $message=[];

        foreach ($selected_ids_new as $branch){
            $branch_es=Branch::where('id',$branch)->whereHas('campaings',function ($q){
                $q->where('campaigns.status',0);
            })->first();
            if($branch_es){
                array_push($message,"Branch : '$branch_es->name' Not Deleted have camp active");
            }else{
                $branches = Branch::where('id',$branch)->first();
                array_push($message,"Branch : '$branches->name' Deleted Successfully");
                Branch::where('id',$branch)->delete();
            }
        }

        return response()->json(['status'=>true,'stat'=>staticticsProfilePage($request['brand_id']),'message'=>$message],200);
    }

    public function edit_all(Request $request){
        /*
            $statusValues = [
                bulk_active => currentStatus
                "active" => ["pending", "inactive", "rejected"]
            ]
        */
        $statusValues = [
            1 => [0, 2, 3],
            2 => [1],
            3 => [0]
        ];

        $selected_ids_new = explode(',',$request->selected_ids);
        $updatedData = [];
        if ($request->input('bulk_active')) $updatedData['status'] = ($request->bulk_active==-1)?"0":$request->bulk_active;
        if($request->input('bulk_expirations_date')) $updatedData['expirations_date'] = $request->bulk_expirations_date;
        if($request->input('bulk_countries')) $updatedData['country_id'] = $request->bulk_countries;
        Brand::whereIn('id',$selected_ids_new)->update($updatedData);
        $statistics = $this->statictics();

        return response()->json(['status'=>true,'data'=>$statistics,'message'=>'Update successfully'],200);
    }

    public function export(Request $request)
    {
        $visibleColumns =  ($request->get('visibleColumns') !== null ) ? array_map('strVal', explode(',', $request->get('visibleColumns'))) : [];
        $selected_ids = ($request->get('selected_ids') !== null) ? array_map('intval', explode(',', $request->get('selected_ids'))) :[];

        return Excel::download(new BrandExport($selected_ids, $visibleColumns, $request), 'brands.xlsx');
    }

    public function branches_export(Request $request,$id){

        $visibleColumns =  ($request->get('visibleColumns') !== null ) ? array_map('strVal', explode(',', $request->get('visibleColumns'))) : [];
        $selected_ids = ($request->get('selected_ids') !== null) ? array_map('intval', explode(',', $request->get('selected_ids'))) :[];
        return Excel::download(new BranchExport($id,$visibleColumns,$selected_ids), 'brand_branches.xlsx');
    }

    /**
     * @param Brand $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Brand $brand){
        if($brand->status){
            $brand->update(['status'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $brand->update(['status'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }

    public function statusToggleBrandBranch(Branch $branch){
        if($branch->status){
            $branch->update(['status'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'Changed Successfully']);
        }
        else{
            $branch->update(['status'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'Changed Successfully']);
        }

    }

    public function getbrandbranchdata($id)
    {
        $branch = Branch::find($id);
        $data = BranchResource::make($branch);
        if($branch){
            return response()->json(['status'=>true,'data'=>$data,'message'=>'Changed Successfully']);
        }
    }

    public function add_to_camp(Request $request){
        $influencers= explode(',',$request->influeIds);
        $created_by=$request->created_by;
        $campaigns=$request->camps_ids;
        $brand_id=$request->brand_id;
        foreach ($influencers as $influencer){
           $influencer_check= Influencer::findOrFail($influencer);
           if($influencer_check){
               foreach ($campaigns as $camp){
                   CampaignInfluencer::updateOrCreate([
                       'brand_id'=>$brand_id,
                       'influencer_id'=>$influencer,
                       'campaign_id'=>$camp['id']
                   ],['brand_id'=>$brand_id,'influencer_id'=>$influencer,'campaign_id'=>$camp['id'],'campaign_type'=>$camp['type'],'status'=>0,'country_id'=>$influencer_check->country_id]);
               }
           }

        }
        return response()->json(['status'=>true,'data'=>'done','message'=>'Added Successfully']);


    }

    public function acceptBrand(Brand $brand,Request $request){
        if($request['data_flag'] == 'active'){
            $status_brand = 1;
            if($request['expire_date'] != -1){
                $updated_data = ['status'=>$status_brand,'expirations_date'=>$request['expire_date']];
                $validator = Validator::make($updated_data, [
                    'expirations_date' => [
                        'after:today'
                    ]
                ]);
                if($validator->fails()){
                    return response()->json(['status'=>false,'message'=>$validator->errors()],200);
                }
            }else{$updated_data = ['status'=>$status_brand];}
        }elseif($request['data_flag'] == 'inactive'){
            $status_brand = 2;
            $updated_data = ['status'=>$status_brand];
        }elseif ($request['data_flag'] == 'reject'){
            $status_brand = 3;
            $updated_data = ['status'=>$status_brand];
        }
        $brand->update($updated_data);
        if($request['data_flag'] == 'active'){
            $status_brand = 1;
        }else{
            $status_brand = 0;
        }
        if($brand->subbrands()->exists()){$brand->subbrands()->update(['status'=>$status_brand]);}
        if($brand->branchs()->exists()){$brand->branchs()->update(['status'=>$status_brand]);}
        return response()->json(['status'=>true,'stats'=>$this->statictics(),'message'=>__('accept successfully')]);
    }


    protected function statictics()
    {

        if(request()->has('country_id')){

            $statistics['totalBrandsAct'] = ['title'=>'Total Companies','id'=>'Total_Brands','count'=>Brand::where('country_id',2)->count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsActive'] = ['title'=>'Active Companies','id'=>'Active_Brands','count'=>Brand::where('country_id',2)->count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsInactive'] = ['title'=>'InActive Companies','id'=>'InActive_Brands','count'=>Brand::where('country_id',2)->count(),'icon'=>'fas fa-toggle-off'];
            $statistics['totalBrandsBending'] = ['title'=>'Pending Companies','id'=>'Pending_Brands','count'=>Brand::where('country_id',2)->count(),'icon'=>'fas fa-solid fa-hourglass-end'];
            $statistics['totalBrandsRejected'] = ['title'=>'Rejected Companies','id'=>'Rejected_Brands','count'=>Brand::where('country_id',2)->count(),'icon'=>'fas fa-solid fa-file-contract'];

        }else{

            $statistics['totalBrandsAct'] = ['title'=>'Total Companies','id'=>'Total_Brands','count'=>Brand::count(),'icon'=>'fas fa-toggle-on', 'value'=>'-1'];
            $statistics['totalBrandsActive'] = ['title'=>'Active Companies','id'=>'Active_Brands','count'=>Brand::where('status',"1")->count(),'icon'=>'fas fa-toggle-on', 'value'=>'1'];
            $statistics['totalBrandsInactive'] = ['title'=>'InActive Companies','id'=>'InActive_Brands','count'=>Brand::where('status',"2")->count(),'icon'=>'fas fa-toggle-off', 'value'=>'2'];
            $statistics['totalBrandsBending'] = ['title'=>'Pending Companies','id'=>'Pending_Brands','count'=>Brand::where('status',"0")->count(),'icon'=>'fas fa-solid fa-hourglass-end', 'value'=>'0'];
            $statistics['totalBrandsRejected'] = ['title'=>'Rejected Companies','id'=>'Rejected_Brands','count'=>Brand::where('status',"3")->count(),'icon'=>'fas fa-solid fa-file-contract', 'value'=>'3'];

        }

        return $statistics;
    }

    public function getstatictics()
    {
        if( request()->has('country_id')){
            $array = request()->country_id;

        $branddd = Brand::when($array, function ($q) use($array){
        $q->whereJsonContains('country_id', $array[0]);
                for($i = 1; $i < count($array); $i++) {
                    $q->orWhereJsonContains('country_id', $array[$i]);
                }
        })->get();

            $statistics['totalBrandsAct'] = ['title'=>'Total Brands','id'=>'Total_Brands','count'=>$branddd->count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsActive'] = ['title'=>'Active Brands','id'=>'Active_Brands','count'=>$branddd->where('status',1)->count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsInactive'] = ['title'=>'InActive Brands','id'=>'InActive_Brands','count'=>$branddd->where('status',2)->count(),'icon'=>'fas fa-toggle-off'];
            $statistics['totalBrandsBending'] = ['title'=>'Pending Brands','id'=>'Pending_Brands','count'=>$branddd->where('status',0)->count(),'icon'=>'fas fa-solid fa-hourglass-end'];
            $statistics['totalBrandsRejected'] = ['title'=>'Rejected Brands','id'=>'Rejected_Brands','count'=>$branddd->where('status',3)->count(),'icon'=>'fas fa-solid fa-file-contract'];

        }else{
            $statistics['totalBrandsAct'] = ['title'=>'Total Brands','id'=>'Total_Brands','count'=>Brand::count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsActive'] = ['title'=>'Active Brands','id'=>'Active_Brands','count'=>Brand::where('status',"1")->count(),'icon'=>'fas fa-toggle-on'];
            $statistics['totalBrandsInactive'] = ['title'=>'InActive Brands','id'=>'InActive_Brands','count'=>Brand::where('status',"2")->count(),'icon'=>'fas fa-toggle-off'];
            $statistics['totalBrandsBending'] = ['title'=>'Pending Brands','id'=>'Pending_Brands','count'=>Brand::where('status',"0")->count(),'icon'=>'fas fa-solid fa-hourglass-end'];
            $statistics['totalBrandsRejected'] = ['title'=>'Rejected Brands','id'=>'Rejected_Brands','count'=>Brand::where('status',"3")->count(),'icon'=>'fas fa-solid fa-file-contract'];

        }

        return $statistics;
    }

    public function getBrandsByCountry($country_id){
        $brand = Brand::whereJsonContains('country_id', $country_id)->orderBy('created_at','desc')->get();
        return response()->json(['status'=>true,'message'=>'Brand Returned successfully', 'data'=>$brand],200);
    }

    public function getsubbrandsByBrands($country_id, $brand_id, Request $request){
        if($country_id !="null" && $brand_id!="null" ){
            if(!is_null($request->sub_brand_id) && $request->url == 'groups'){
                $subBrand =  Subbrand::where('id', $request->sub_brand_id)->where('brand_id', $brand_id)->where('status',1)->whereJsonContains('country_id', $country_id)->whereDoesntHave('branches')->get();
            }else{
                $subBrand =  Subbrand::where('brand_id', $brand_id)->whereDoesntHave('branches')->where('status',1)->whereJsonContains('country_id', $country_id)->get();
            }
            return response()->json(['status'=>true,'message'=>'Brand Returned successfully', 'data'=>$subBrand],200);
        }else{
            if(!is_null($request->sub_brand_id) && $request->url == 'groups'){
                $subBrand =  Subbrand::where('id', $request->sub_brand_id)->where('brand_id', $brand_id)->get();
            }else{
                $subBrand =  Subbrand::where('brand_id', $brand_id)->get();
            }
            return response()->json(['status'=>true,'message'=>'Brand Returned successfully', 'data'=>$subBrand],200);
        }


    }

    public function BrandNotAssignedBranchesToSubBrand($id,$country){
        $countries=explode(',',$country);
        $branches = Branch::where(['subbrand_id' => 0, 'brand_id'=>$id])->WhereIn('country_id', $countries)->get();
        return response()->json(['status' => true, 'message' => 'branches Returned successfully', 'data'=>$branches]);
    }


    public function dislikeList($id){
        $influencers = BrandDislike::where('brand_id',$id)->whereHas('influencer', function($q){
            $q->where('deleted_at', null);
        })->get();
        $dislike = DislikeResource::collection($influencers);
        return datatables($dislike)->make(true);
    }


    public function bulkDelete(Request $request){
        BrandDislike::whereIn('influencer_id',$request['id'])->where("brand_id", $request['brand_id'])->delete();
        return response()->json(['status'=>true,'message'=>'addedd'],200);
    }

    // function get Brand Details

    public function get_brand_details(){
     $id =   \request('brand_id');
     $type =   \request('type');
     if($type == 'brand')
        $brand = Brand::with('user')->find($id);
     else
         $brand = Influencer::with('user')->find($id);

     return response()->json(['status'=>true,'BrandDetails'=>$brand]);
    }

    public function get_details(){
       $data=[];
       $subBrand=Subbrand::findOrFail(\Request()->brand_id);
       $countries = Country::whereIn('id', array_map('intval', (array)$subBrand['country_id']))->select('code')->get()->toArray();
       $data=['total'=>$subBrand->grouplists->count(),'active'=>$subBrand->groupLists->where('status',1)->count(),'inactive'=>$subBrand->groupLists->where('status',0)->count(),'brand_details'=>$subBrand,'countries'=>$countries];
     return $data;
    }
 public function getBrandCountries(){
    $brand = Brand::find(request()->brand_id);
    if($brand->brand_countries()->exists()){
        $countries = Country::whereIn('id',$brand->country_id)->get(['id','name']);
        return response()->json(['brand'=>$brand,'countries'=>$countries]);
    }
    return response()->json(['brand'=>$brand,'countries'=>[]]);
 }
 public function updateBrandCountries(){

     $brand =   Brand::find(request()->brand_id);
     if(!\request('expirations_date')){
         return response()->json(['status' => false, 'msg'=>'Please select expiration date','brand'=>$brand]);
     }
     $brand->update(['status'=>1, 'expirations_date' => \request('expirations_date')]);
//       Brand::find(request()->brand_id)->update(request()->except('_token','brand_id'));
//         if(request()->country_id){
//             BrandCountry::whereBrandId(request()->brand_id)->whereIn('country_id',request()->country_id)->update(['status'=>1]);
//         }
         return response()->json(['status' => true, 'msg'=>'Updated Successfully','brand'=>$brand]);

 }

 public function getGroupListOfBrand(Request $request, $id){
	$search = $request->q['term']??null;
    $groupList = GroupList::where('brand_id',$id);

    if($search){
        $groupList = $groupList->where('name','like',"%{$search}%");
    }

     $groupList = $groupList->paginate(10);

     $paginategroupList  = $groupList ->toArray();
	$total = $paginategroupList['total'];
	$result = [];
	foreach($groupList as $item){
		$result[] = ['id' =>  $item->id ,'text' => $item->name];
	}
    return response()->json(['total'=>$total,'results'=>$result]);
}

public function getAllBrands(Request $request, $id){
	$search = $request->q['term'];
    $brandList = Brand::where('id','!=',$id)->where('name','like',"%{$search}%")->paginate(10);
	$paginatebrandList  = $brandList ->toArray();
	$total = $paginatebrandList['total'];
	$result = [];
	foreach($brandList as $item){
		$result[] = ['id' =>  $item->id ,'text' => $item->name];
	}
    return response()->json(['total'=>$total,'results'=>$result]);
}

public function updateBrand_Status(){
   $brand =  Brand::find(request()->brand_id);
   $brand->update(['status'=>request()->status]);
   return response()->json(['msg'=>'success','brand'=>$brand ,'status'=>200]);

}

public function wishlistExport(Request $request){
        $brandData = Brand::find($request->brand_id);
      $brand_name = $brandData->name;
	  $filter = \request()->only(['brand_id','visited_campaign','sub_brand','groupId','country_taps','del']);
    $brandDislikesIds = BrandDislike::where('brand_id', (int)$brandData->id)->pluck('influencer_id')->toArray();
    $influencersQuery = $this->influencer->getBrandFavouritesQuery($brandData, $brandDislikesIds, $filter);
	return Excel::download(new \App\Exports\WishlistExport($influencersQuery, $brandData, $filter), $brand_name.'wishlist.xlsx');
}
public function download(Request $request)
    {
    	// get the request value
    	$input = request()->all();
    	// set header
        $columns = [
           'instagram_username','snapchat_username','tiktok_username','facebook_username','twitter_username',
           'Name','Type_phone1','Zip_phone1','Type_phone2','Zip_phone2','Type_phone3',
           'Zip_phone3','country','governorate','city','address_ar','address_en',
           'date_of_birth','Category','Interests','Gender','Lang','ethink_category','marital_status','account_type',
           'coverage_platform','have_children','classification','email','nationality','status'
        ];

        // create csv
        return response()->streamDownload(function() use($columns, $input) {
            $file = fopen('php://output', 'w+');
            fputcsv($file, $columns);

            $data = Influencer::select('*')->orderBy('id', 'desc');

            $data = $data->cursor()
            ->each(function ($data) use ($file) {
                $data = InfluencerResource::collection($data);;
                fputcsv($file, $data);
            });

            fclose($file);
        }, 'AllUsersCSV'.date('d-m-Y').'.csv');
    }

    public function getSubbrandCountries($id){
        $subBrand = Subbrand::find($id);
        if($subBrand){
            if($subBrand->countries()->exists()){
                $countries = Country::whereIn('id',$subBrand->country_id)->get(['id','name']);
                return response()->json(['countries'=>$countries]);
            }
        }
        return response()->json(['countries'=>[]]);
    }
}
