<?php

namespace App\Http\Services;

use App\Exports\SubBrandExport;
use App\Http\Services\Interfaces\SubBrandServicesInterface;
use App\Models\Branch;
use App\Models\Subbrand;
use App\Models\Country;
use App\Repository\Interfaces\SubBrandsRepositoryInterface;
use http\Env\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SubBrandServices implements SubBrandServicesInterface
{
    protected $subBrandsRepo;

    public function __construct(SubBrandsRepositoryInterface $subBrandsRepo){
        $this->subBrandsRepo = $subBrandsRepo;
    }

    public function all(){
        $statistics = $this->subBrandsRepo->getStatistics();
        return view('admin.dashboard.sub-brands.index',compact('statistics'));
    }


    public function getSubBrands(){
        if(\request()->hasHeader('auth-id') && \request()->header('auth-id') == auth()->id()){
			$filter = \request()->only(['brand_id','status_val','country_val','start_date','end_date','brands_status']);
			$subBrands = Subbrand::join('brands','brands.id','=','subbrands.brand_id')->select('subbrands.*','brands.name as brand_name')->ofFilter($filter);
			return  \DataTables::of($subBrands)->editColumn('country_id',function($item){return $countries = Country::whereIn('id', array_map('intval', (array)$item->country_id))->select('id','code')->get()->toArray(); })
			->addColumn('branches',function($item){ return @$item->branches ? @$item->branches->pluck('name','id')->toArray() : null; })
			->addColumn('social',function($item){return  [$item->link_insta,$item->link_facebook,$item->link_tiktok,$item->link_twitter,$item->link_snapchat,$item->link_website];})
			->addColumn('active_data',function($item){return  ['id'=>$item->id,'active'=>$item->status];})
			->editColumn('expirations_date',function($item){ return @$item->expirations_date; })
			->editColumn('created_at',function($item){ return @$item->created_at ? Carbon::parse($item->created_at)->format("Y-m-d") :''; })
			->make(true);
        }else{
            return \response()->json(['status'=>false,'message'=>'unauthenticated'],401);
        }
    }

    public function store($request){
        $inputs = $request->except(['_token','branches','ids','subbrand_name','subbrand_status', 'id', 'sub_brand', 'branch_ids']);

        $inputs['name'] = $request['name'];
        $inputs['status'] = $request['status'];
       $subBrandId= $this->subBrandsRepo->createSubBrand($inputs);
        if(!empty($request->branch_ids)){
            $this->subBrandsRepo->assignSubBrandToBranches($request->branch_ids,$subBrandId);
        }

        // if($request->ajax()){
        //     return \response()->json(['status'=>true,'stats'=>staticticsProfilePage($request->brand_id),'message'=>'created'],200);
        // }
        return response()->json(['status'=>true,'route'=>route('dashboard.sub-brands.index'),'message'=>'User Stored successfully'],200);
    }

    public function edit($subBrand,$request){
        $countriesInSubBranches = [];
        foreach ($subBrand->branches as $brandRow){
            $countriesInSubBranches[] = $brandRow->country_id;
        }
        $countriesInSubBranches = array_map('intval', $countriesInSubBranches);
        if($request->ajax()){
            $subBrand['branch_id'] = $subBrand->branches()->get();
            $branches =  Branch::where(['subbrand_id' => 0, 'brand_id'=>$subBrand->brand_id])->orWhere('subbrand_id',$subBrand->id )->get();
            return \response()->json(['status'=>true,'data'=>$subBrand, 'branches'=>$branches, 'countriesInSubBranches' => $countriesInSubBranches, 'message'=>'created'],200);
        }else{
            $branchesHandel =  $this->subBrandsRepo->editSubBrand($subBrand);
            return view('admin.dashboard.sub-brands.edit',compact('subBrand','branchesHandel', 'countriesInSubBranches'));
        }
    }

    public function update($request, $subBrand){
        $inputs = $request->except(['_token','_method']);
        $this->subBrandsRepo->updateSubBrand($inputs,$subBrand);
        // if(!empty($request->branches)){
        //     $this->createSubBrandBranches($request, $subBrand);
        //     $this->updateSubBrandBranches($request, $subBrand);
        // }
        // if(!empty($request->branch_ids))
        // {
        //     $this->subBrandsRepo->assignSubBrandToBranches($request->branch_ids,$subBrand);
        // }
//        $this->updateSubBrandBranches($request,$subBrand);
        // if($request->ajax()){
        //     $inputs['countries'] = [];
        //     $inputs['image'] = Subbrand::find($subBrand->id)->image;
        //     foreach($inputs['country_id'] as $country){
        //         array_push($inputs['countries'], country($country)->code);
        //     }
        //     return \response()->json(['status'=>true,'message'=>'created', 'data' => $inputs],200);
        // }
        return response()->json(['status'=>true,'route'=>route('dashboard.sub-brands.index'),'message'=>'User Updated successfully'],200);
    }

    public function createSubBrandBranches($request,$subBrand){
        $branches = json_decode($request['branches'])??[];
            foreach ($branches as $branch){
                $branch->brand_id = $request['brand_id'];
                $branch->country_id = $branch->branch_country_id;
                $branch->status = (string)$branch->status;
                $branch = (array)$branch;
                $subBrand->branches()->create($branch);
            }
    }

    public function updateSubBrandBranches($request,$subBrand){
        $branches =json_decode($request['branches']);
        $branchesIds = [];
        foreach ($branches as $key=>$branch){
            if(isset($branch->subbrand_id)){
                $branchDb =  Branch::where('id',$branch->_id)->where('subbrand_id',$branch->subbrand_id)->first();
                if($branch){
                    $branchDb->update([
                        'name' => $branch->name,
                        'status' => (string)$branch->status,
                        'city' => $branch->city,
                        'country_id' => $branch->branch_country_id,
                    ]);
                }

            }else{
                $branchDb = Branch::create([
                    'name' => $branch->name,
                    'status' => (string)$branch->status,
                    'city' => $branch->city,
                    'country_id' => $branch->branch_country_id,
                    'subbrand_id' => $subBrand->id,
                    'brand_id' => $subBrand->brand_id,
                ]);
            }
            $branchesIds[$key] = $branchDb->id;
        }

        Branch::whereNotIn('id',$branchesIds)->where('subbrand_id',$subBrand->id)->delete();
    }
    public function export($request)
    {
        $visibleColumns =  ($request->get('visibleColumns') !== null ) ? array_map('strVal', explode(',', $request->get('visibleColumns'))) : [];
        $selected_ids = ($request->get('selected_ids') !== null) ? array_map('intval', explode(',', $request->get('selected_ids'))) :[];
        $brand_id=$request->brand_id;
        return Excel::download(new SubBrandExport($visibleColumns,$selected_ids,$brand_id), 'subbrands.xlsx');
    }
}
