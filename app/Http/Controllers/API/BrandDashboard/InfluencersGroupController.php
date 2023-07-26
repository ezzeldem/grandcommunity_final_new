<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupListRequest;
use App\Http\Requests\API\BrandDashboard\AddInfluesToGroupsRequest;
use App\Http\Resources\API\GroupResource;
use App\Http\Traits\ResponseTrait;
use App\Models\BrandDislike;
use App\Models\BrandFav;
use App\Repository\Interfaces\GroupListInterFace;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class InfluencersGroupController extends Controller
{
    use ResponseTrait;

    /**
     * @var GroupListInterFace
     */
    protected $group;

    /**
     * @param GroupListInterFace $group
     */
    public function __construct(GroupListInterFace $group){
        $this->group = $group;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allGroups(Request $request){
        $user = auth()->user();
        $brand =  $user->brands;
        $filter = $request->all();
        $dislikesIds = BrandDislike::where('brand_id', (int) $brand->id)->pluck('influencer_id')->toArray();
        $paginatedBrand= $this->group->getGroupListsWithInfluencersCountQuery($brand->id, (is_array($brand->country_id)?$brand->country_id:[]), $dislikesIds)->offilter($filter)->orderBy('group_lists.id', 'desc')->paginate($request['limit']??20);
        $groups['data'] = GroupResource::collection($paginatedBrand);
        if($paginatedBrand instanceof LengthAwarePaginator){
            $queries = array();
            if(isset($_SERVER['QUERY_STRING'])){
                parse_str($_SERVER['QUERY_STRING'], $queries);
                if(isset($queries['page']))
                    unset($queries['page']);
            }
            $groups['pagination']=[
                'total' => $paginatedBrand->total(),
                'count' => $paginatedBrand->count(),
                'per_page' => $paginatedBrand->perPage(),
                'next_page_url' => handleQueryInPagination($paginatedBrand->nextPageUrl(),$queries),
                'prev_page_url' => handleQueryInPagination($paginatedBrand->previousPageUrl(),$queries),
                'current_page' => $paginatedBrand->currentPage(),
                'last_page' => $paginatedBrand->lastPage(),
            ];
        }
        return $this->returnData('group_list',$groups);
    }

    /**
     * @param GroupListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addGroup(GroupListRequest $request){
        $groups=$this->group->create_groups($request);
        $country_id=[];
        foreach ($groups->country_id as $value){
            array_push($country_id, $value);
        }
        $groups['country_id']=$country_id;
        return  $this->returnData('data',$groups,__('api.Groups added successfully'));
    }

    /**
     * @param AddInfluesToGroupsRequest $request
     * @return array
     */
    public function addToGroups(AddInfluesToGroupsRequest $request){

           $result=$this->group->copyInflueBrandGroup($request);
		   return response()->json(['status'=>true,'messages'=>$result['messages'],'influencers'=>$result['results'],'total_failed'=>$result['total_failed'],'total_success'=>$result['total_success']],200);
    }
}
