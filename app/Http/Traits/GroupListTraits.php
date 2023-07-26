<?php

namespace App\Http\Traits;

use App\Models\Brand;
use App\Models\Country;

trait GroupListTraits
{
    public function brandGroupList($brand,$countries){

            if(gettype($brand->id) == 'integer'){
                $brandData = Brand::find($brand->id);
            }elseif ($brand instanceof Brand){
                $brandData = $brand;
            }

            $groups = $brandData->group_lists()->with('countries',function ($q)use($countries){
                $q->whereIn('id',$countries);
            })->get()->groupBy('countries.*.name');

        return $groups;
    }
}
