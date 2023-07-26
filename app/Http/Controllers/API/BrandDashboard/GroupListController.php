<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupListRequest;
use App\Http\Resources\API\GroupResource;
use App\Http\Resources\API\SubBrandResource;
use App\Http\Traits\ResponseTrait;
use App\Models\BrandDislike;
use App\Models\Country;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\User;
use App\Repository\Interfaces\GroupListInterFace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupListController extends Controller
{
    use ResponseTrait;
    public $group;

    public function __construct(GroupListInterFace $group)
    {
        $this->group = $group;
    }

    public function index(Request $request)
    {
        $limit = (request()->get("paginate")) ? (request()->get("paginate") != "-1" ? request()->get("paginate") : 5000 ) : 20;
        $brand = User::find(auth()->user()->id);
        $filter = $request->only(['name']);
        $brandAccount = $brand->brands;
        $brandId = $brandAccount->id;
        $countriesIds = is_array($brandAccount->country_id)?$brandAccount->country_id:[];
       // $dislikesIds = BrandDislike::where('brand_id', (int) $brandId)->pluck('influencer_id')->toArray();
        $paginatedBrand= $this->group->getGroupListsWithInfluencersCountQuery($brandId, $countriesIds, [])->offilter($filter)->orderBy('group_lists.id', 'desc')->paginate($limit);
        $groups = GroupResource::collection($paginatedBrand);

        $noGroupCount = Influencer::where('influencers.active', 1)
        ->Join('influencers_groups', function($join) use ($brandId) {
            $join->on('influencers_groups.influencer_id', '=', 'influencers.id')
                ->where('influencers_groups.brand_id', $brandId)
                ->whereNull('influencers_groups.deleted_at')
                ->whereNull('influencers_groups.group_list_id')
                ->whereraw('influencers_groups.influencer_id not in (select influencer_id from brand_dislikes where brand_id = '.$brandId.')');
        })->whereraw('influencers.id not in (select influencer_id from `influencers_groups` where `brand_id` = '.$brandId.' AND `group_list_id` IS NOT NULL AND `group_deleted_at` IS NULL AND `deleted_at` IS NULL)');


        if(count($countriesIds) > 0){
            $noGroupCount = $noGroupCount->whereIn('influencers.country_id', $countriesIds);
        }
        $noGroupCount = $noGroupCount->distinct()->count();

        // $sql = \Str::replaceArray('?', $noGroupCount->getBindings(), $noGroupCount->toSql());
        // dd($sql);

        $response['group_list'] = $groups;
        $response['count'] = $paginatedBrand->total();
        $response['per_page'] = (int)$paginatedBrand->perPage();
        $response['current_page'] = (int)$paginatedBrand->currentPage();
        $response['last_page'] = $paginatedBrand->lastPage();
        $response['total'] = (int)$paginatedBrand->total();
        $response['no_group_count'] = $noGroupCount;
        return $this->returnData('data',$response);
    }

    public function store(GroupListRequest $request){
        $groups=$this->group->create_groups($request);
//        $country_id=[];
//
//        foreach ($groups->country_id as $group){
//            array_push($country_id,strtolower($group['code']));
//        }

        $groups['country_id']= is_array($groups->country_id)?$groups->country_id:[];
        if($request->has('id')&& $request['id']!=null)
            return  $this->returnData('data',$groups,__('api.Groups updated successfully'));
        else
            return  $this->returnData('data',$groups,__('api.Groups added successfully'));
    }

    public function delete_all(Request $request){
        $groups=$this->group->delete_all($request);
        return  $this->returnSuccessMessage(__('api.Groups Deleted successfully'));
    }

    public function copyInflue(Request $request){
        $result =$this->group->copyInflueBrandGroup($request,true);
        return response()->json(['status'=>true,'message'=>$result['messages'],'influencers'=>$result['results'],'total_failed'=>$result['total_failed'],'total_success'=>$result['total_success']],200);
    }
    public function moveInflue(Request $request){
        $result =$this->group->moveInflueBrandGroup($request);
        return response()->json(['status'=>true,'message'=>$result['messages'],'influencers'=>$result['results'],'total_failed'=>$result['total_failed'],'total_success'=>$result['total_success']],200);
    }
    public function removeInflue(Request $request){
        $this->group->deleteInflueGroup($request);
        return response()->json(['status'=>true,'message'=>__('api.successfully_deleted')],200);
    }
}
