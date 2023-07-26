<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubBrandExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubBrandRequest;
use App\Http\Resources\Admin\BranchResource;
use App\Http\Resources\Admin\CampaignResource;
use App\Http\Services\Interfaces\SubBrandServicesInterface;
use App\Imports\SubBrandsImport;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Subbrand;
use App\Models\Country;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class SubBrandsController extends Controller
{
    public $subBrandsRepo;

    function __construct(SubBrandServicesInterface $subBrandsRepo)
    {
        $this->subBrandsRepo = $subBrandsRepo;
        $this->middleware('permission:read sub-brands|create sub-brands|update sub-brands|delete sub-brands', ['only' => ['index','show','export']]);
        $this->middleware('permission:create sub-brands', ['only' => ['create','store','import']]);
        $this->middleware('permission:update sub-brands', ['only' => ['edit','update','statusToggle','edit_all']]);
        $this->middleware('permission:delete sub-brands', ['only' => ['destroy','bulkDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->subBrandsRepo->all();
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Exception
     */
    public function getSubBrands(){
        return $this->subBrandsRepo->getSubBrands();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $countriesInSubBranches = [];
        return view('admin.dashboard.sub-brands.create', compact('countriesInSubBranches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubBrandRequest $request)
    {
        return $this->subBrandsRepo->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  Subbrand $subBrand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
       $subbrand = Subbrand::findOrFail($id);
	   $brand = $subbrand->brand;
        if(!$request->brand_id){
            return redirect()->to(route('dashboard.sub-brands.show', $id)."?brand_id=".$brand->id);
        }
	   $brand['countries_id'] = Country::select('id','name','code')->whereIn('id', array_map('intval', $brand->country_id))->get();
	   $camp_status =[];// $this->campaignService->getStatus();
       $camp_types = campaignType();
		//dd($subbrand);
		$subbrand['countries_id']=Country::select('id','name','code')->whereIn('id', array_map('intval', $subbrand->country_id))->get();
		 // return view('admin.dashboard.brands.view_tabs.group_of_brand_view',$input);
		return view('admin.dashboard.brands.subbrand', compact('subbrand','brand','camp_types','camp_status'));
    }

    public function getSubBrandCampaigns($id,Request $request){
        if(isset($request->url) && !is_null($request->url) && $request->url == 'groups'){
            $subbrand = Subbrand::find($request->sub_brand_id);
            $filter = $request->only(['status_val', 'country_val','campaign_type_val', 'start_date', 'end_date']);
            $query = $subbrand->campaigns()->where('sub_brand_id',$id)->ofFilterCamp($filter)->get();
        }else{
            $query = Campaign::where('sub_brand_id',$id)->ofFilterCamp($request)->get();
        }
        $data = CampaignResource::collection($query);
        return Datatables::of($data)->make(true);
    }

    public function getSubBrandBranches($id,Request $request){
        if(isset($request->url) && !is_null($request->url) && $request->url == 'groups'){
            $subbrand = Subbrand::find($id);
            $filter = \request()->only(['status_val','country_val','start_date','end_date','brand_val','subbrand_val','city_val']);
            $query = $subbrand->branches()->ofFilterBrand($filter)->orderBy('id','desc')->get();
        }else{
            $query = Branch::where('subbrand_id',$id)->ofFilterBrand($request)->orderBy('id','desc')->get();
            foreach ($query as $b){
                $b['active_data'] =['id'=>$b->id,'active'=>$b->status];
            }
        }

        $data = BranchResource::collection($query);

        return Datatables::of($data)->make(true);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Subbrand $subBrand
     * @return \Illuminate\Http\Response
     */
    public function edit(Subbrand $subBrand,Request $request)
    {
        return $this->subBrandsRepo->edit($subBrand,$request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SubBrandRequest  $request
     * @param  Subbrand $subBrand
     * @return \Illuminate\Http\Response
     */
    public function update(SubBrandRequest $request, Subbrand $subBrand)
    {
        return $this->subBrandsRepo->update($request,$subBrand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subbrand $subBrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subbrand $subBrand)
    {
        $hascamp=$subBrand->campaigns();
        if(!$hascamp->exists()){
            $subBrand->branches()->delete();
            Subbrand::where('id',$subBrand->id)->delete();
            return response()->json(['status'=>true,'stat'=>staticticsProfilePage(\request('brand_id')),'message'=>'Deleted Successfully'],200);
        }
        return response()->json(['status'=>false,'message'=>'Can not Deleted, As SubBrand Contains active Campaign'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request){
        $message=[];
       foreach ($request['id'] as $sub){
          $subrand=Subbrand::where('id',$sub)->whereHas('campaigns',function ($q){
              $q->where('campaigns.status',0);
          })->first();
          if($subrand){
             array_push($message,"Group Of Brand : '$subrand->name' Not Deleted have camp active");
          }else{
              $subrands = Subbrand::where('id',$sub)->first();
              array_push($message,"Group Of Brand : '$subrands->name' Deleted Successfully");
              Subbrand::where('id',$sub)->delete();
              $subrands->branches()->delete();
          }
       }
        return response()->json(['status'=>true,'stat'=>staticticsProfilePage($request['brand_id']),'message'=>$message],200);
    }

    public function edit_all(Request $request){
        $selected_ids_new = explode(',',$request->selected_ids);
        if($request->input('bulk_active')){
            Subbrand::whereIn('id',$selected_ids_new)->update([
                'status'=>($request->bulk_active==1)?'1':'0',
            ]);
        }if($request->input('bulk_gender')){
            Subbrand::whereIn('id',$selected_ids_new)->update([
                'preferred_gender'=>$request->bulk_gender,
            ]);
        }if($request->input('bulk_expirations_date')){
            Subbrand::whereIn('id',$selected_ids_new)->update([
                'expirations_date'=>$request->bulk_expirations_date,
            ]);
        }
        return response()->json(['status'=>true,'data'=>'done','message'=>'Update successfully'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        Excel::import(new SubBrandsImport(), $request->file);
        return redirect()->route('dashboard.sub-brands.index')->with(['successful_message' => 'data inserted successfully']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request){
        return $this->subBrandsRepo->export($request);

    }
    /**
     * @param Subbrand $subBrand
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusToggle(Subbrand $subBrand){
        if($subBrand->status){
            $subBrand->update(['status'=>0]);
            return response()->json(['status'=>true,'active'=>false,'message'=>'change successfully']);
        }
        else{
            $subBrand->update(['status'=>1]);
            return response()->json(['status'=>true,'active'=>true,'message'=>'change successfully']);
        }
    }
}
