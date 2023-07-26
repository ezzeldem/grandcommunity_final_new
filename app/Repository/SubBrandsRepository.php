<?php

namespace App\Repository;

use App\Http\Resources\Admin\SubBrandResource;
use App\Models\Country;
use App\Models\Subbrand;
use App\Models\Branch;
use App\Repository\Interfaces\SubBrandsRepositoryInterface;

class SubBrandsRepository implements SubBrandsRepositoryInterface
{
    protected $model;

    public function __construct(Subbrand $model){
        $this->model=$model;
    }

    public function getStatistics(){
        $statistics['totalSubBrands'] = ['id'=>'totalSubBrands','title'=>'Total Brands','count'=>$this->model::count(),'icon'=>'fab fa-bandcamp', 'value'=>'-1'];
        $statistics['activeSubBrands'] = ['id'=>'activeSubBrands','title'=>'Active Brands','count'=>$this->model::where('status',1)->count(),'icon'=>'fas fa-toggle-on', 'value'=>'1'];
        $statistics['inactiveSubBrands'] = ['id'=>'inactiveSubBrands','title'=>'Inactive Brands','count'=>$this->model::where('status',0)->count(),'icon'=>'fas fa-toggle-off', 'value'=>'0'];
        return $statistics;
    }

    public function getSubBrand(){
        $filter = \request()->only(['brand_id','status_val','country_val','start_date','end_date','brands_status']);
        $subBrands = SubBrandResource::collection($this->model::ofFilter($filter)->orderBy('id','desc')->get());
        return $subBrands;
    }

    public function createSubBrand($inputs){
        return $this->model->create($inputs);
    }
    public function assignSubBrandToBranches($branches,$subBrand){
        $branches = Branch::whereIn('id', $branches)->get();
        foreach($branches as $branch){
            $branch->update(['subbrand_id' => $subBrand->id]);
        }
    }
    public function editSubBrand($subBrand){
        $branches = $subBrand->branches->transform(function ($q){
            $country = Country::where('id',intval($q->country_id))->first();
            return[
                '_id'=>$q->id,
                'name'=>$q->name,
                'city'=>$q->city,
                'branch_country_id'=>$country->id,
                'country_name'=>$country->name,
                'brand_id'=>$q->brand_id,
                'subbrand_id'=>$q->subbrand_id,
                'status'=>$q->status,
            ];
        })->toArray();
        $branchesHandel = json_encode($branches);
        return $branchesHandel;
    }

    public function updateSubBrand($inputs,$subBrand){
        $subBrand->update($inputs);
    }

}
