<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupListRequest;
use App\Imports\GroupListInflueImport;
use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\BrandFav;
use App\Models\Country;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Models\Subbrand;
use App\Repository\Interfaces\GroupListInterFace;
use App\Repository\Interfaces\InfluencerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GroupListController extends Controller
{
    public $group;
    public $influencer;

    public function __construct(GroupListInterFace $group, InfluencerInterface $influencer)
    {
        $this->group = $group;
        $this->influencer = $influencer;
        $this->middleware('permission:read group lists|create group lists|update group lists|delete group lists', ['only' => ['index','show']]);
        $this->middleware('permission:create group lists', ['only' => ['create','create_groups','copyInflueGroup']]);
        $this->middleware('permission:update group lists', ['only' => ['edit','moveInflueGroup','import']]);
        $this->middleware('permission:delete group lists', ['only' => ['deleteInflueGroup','delete_all']]);
    }

    public function show($id){
          $groups=GroupList::select(['id','name','brand_id','country_id','color'])->where('id',$id)->first();
		return response()->json(['status'=>'true','data'=>$groups],200);
    }

    public function create_groups(GroupListRequest $request){
        $groups=$this->group->create_groups($request);
       return response()->json(['status'=>'true','data'=>$groups,'flag'=>$request['flag']],200);
    }

    public function delete_all(Request $request){
        $request['selected_ids'] = explode(',', $request->selected_ids);
        $this->group->delete_all($request);
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function restore_all(Request $request){
        $this->group->restore_all($request);
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function groupListBrand(Request $request){
//fixme::groupUpdates
        $brandId = $request->brand_id;
        $brand_id = $brandId;
        $groupId = (isset($request['groupId']) && (int) $request['groupId'] > 0) ?  (int) $request['groupId'] : null;
        $user = auth()->user();
        $brandData = Brand::find($brand_id);

		$filter = \request()->only(['groupId', 'brand_id', 'country_id', 'country_taps', 'custom','del','visited_campaign']);
        $brandDislikesIds = BrandDislike::where('brand_id', (int)$brandId)->pluck('influencer_id')->toArray();
        $influencersGroups = $this->influencer->getBrandFavouritesQuery($brandData, $brandDislikesIds, $filter);


		return  \DataTables::of($influencersGroups)->editColumn('name',function($item){return ($item->instagram) ? $item->instagram->name : $item->name; })
			->addColumn('country_id',function($item){ return Country::where('id',$item->country_id)->select('id','name','code')->first()?->toArray(); })
			->addColumn('social',function($item){return  ['insta_uname' => $item->insta_uname, 'facebook_uname' => $item->facebook_uname,'tiktok_uname' => $item->tiktok_uname, 'twitter_uname' => $item->twitter_uname,'snapchat_uname' => $item->snapchat_uname];})
			->addColumn('groups',function($item) use ($brand_id) {
				$wishlist = $item->getJoinGroupsByBrandId(@$brand_id);
				return ($wishlist) ? $wishlist['groups'] : [] ;})
			->editColumn('created_at',function($item) use ($brand_id, $request){
				$wishlist = $item->getJoinGroupsByBrandId(@$brand_id);
				if($request->has('favorite') && $request->favorite =="-1")
					return $added_date=($wishlist) ? Carbon::parse($wishlist['main_added_date'])->format("Y-m-d") : Carbon::parse($item->created_at)->format("Y-m-d");
				elseif($request->has('favorite') && $request->favorite > 0)
				  return $added_date=($item->getJoinGroupsByBrandId(@$brand_id,$request->favorite)) ? Carbon::parse($item->getJoinGroupsByBrandId(@$brand_id,$request->favorite)['group_added_date'])->format("Y-m-d") : Carbon::parse($item->created_at)->format("Y-m-d") ;
			    else
				return Carbon::parse($item->created_at)->format("Y-m-d");
		})->addColumn('visited_camapaigns',function($item) use ($brand_id) { return $item->campaignVisitedByBrandId(@$brand_id); })
		->make(true);

	/*	$filter = \request()->only(['brand_id','status_val','country_val','start_date','end_date','brands_status']);
			$groups = Influencer::doesnthave('dislikes')->ofGroupFilter($filter);
			return  \DataTables::of($groups)->editColumn('country_id',function($item){return $countries = Country::whereIn('id', array_map('intval', (array)$item->country_id))->select('id','code')->get()->toArray(); })
			->addColumn('branches',function($item){ return @$item->branches ? @$item->branches->pluck('name','id')->toArray() : null; })
			->addColumn('social',function($item){return  [$item->link_insta,$item->link_facebook,$item->link_tiktok,$item->link_twitter,$item->link_snapchat,$item->link_website];})
			->addColumn('active_data',function($item){return  ['id'=>$item->id,'active'=>$item->status];})
			->editColumn('expirations_date',function($item){ return @$item->expirations_date; })
			->editColumn('created_at',function($item){ return @$item->created_at ? Carbon::parse($item->created_at)->format("Y-m-d") :''; })
			->make(true);
*/
      /*  $limit = (request('length')) ? (request('length') != "-1" ? request('length') : "5000" ) : 20;

        $start = \request('start');
        $brand = $request->brand_id;
        if($request->brand_id == 0 && $request->sub_brand_id != 0){
            $sub_brand = Subbrand::find($request->sub_brand_id);
            $brand = $sub_brand->brand_id;
            $request['brand_id'] = $sub_brand->brand_id;
        }

        $query= $this->group->groupListBrand();
        $count =Influencer::whereHas('brands',function ($q) use($brand){
            $q->where('brands.id',(int)$brand);
            })->count();

        return Datatables::of($query)->setOffset($start)->with(['recordsTotal'=>$count, "recordsFiltered" => Influencer::ofGroupFilter($request->all())->count(),'start' => $start])->make(true);

*/
	}

    public function removeInflueGroupList(Request $request){
        $influencer = Influencer::find($request->influencer_id);
        if(is_null($request->group_id)){
            $influencer_groups = $influencer->brand_favorites()->first()->group_list_id;
            foreach($influencer_groups as $group){
                DB::statement("UPDATE brand_favorites
                SET group_list_id =
                    JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$group['list_id']}', null, '$[*].list_id' ) , '.list_id' , '' )),
                        json_object('list_id','{$group['list_id']}','created_at',NOW(),'created_by','1','deleted_at',now()))
                WHERE JSON_SEARCH(group_list_id, 'one',{$group['list_id']}) IS NOT NULL and `influencer_id` in({$influencer->id})");
            }
            return response()->json(['status'=>true,'message'=>'Removed successfully'],200);
        }else{
            DB::statement("UPDATE brand_favorites
                SET group_list_id =
                    JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$request->group_id}', null, '$[*].list_id' ) , '.list_id' , '' )),
                        json_object('list_id','{$request->group_id}','created_at',NOW(),'created_by','1','deleted_at',now()))
                WHERE JSON_SEARCH(group_list_id, 'one',{$request->group_id}) IS NOT NULL and `influencer_id` in({$influencer->id})");

            return response()->json(['status'=>true,'message'=>'Removed successfully'],200);
        }


    }

    public function copyInflueGroup(Request $request){

		switch($request->copy_move_type){
			case '1':
				$results=$this->group->moveInflueBrandGroup($request);
			break;
			default:
			   $results=$this->group->copyInflueBrandGroup($request);
			break;
		}
        return response()->json($results,200);
    }

    public function deleteInflueGroup(Request $request){
        $this->group->deleteInflueGroup($request);
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }

    public function deleteDislikeInflueGroup(Request $request){
        $this->group->deleteInflueGroup($request);
        return response()->json(['status'=>true,'message'=>'deleted successfully'],200);
    }


    public function import(){
        try {
            $getAttr = new GroupListInflueImport();
            Excel::import($getAttr, request()->file('file')->store('temp'));
            $message_success = $getAttr->messages_success;
            return response()->json(['status' => true, 'message' => $message_success], 200);
        }
        catch (ValidationException $e) {

            $errorst =[];
            foreach ($e->failures() as $failure)
                $errorst[] = "Row : {$failure->row()} , {$failure->errors()[0]}";

        }
        return response()->json(['status' => false, 'message' => 'Please make sure that you fill all data'], 200);
    }
    public function getGroupsBrand($brand){
        $idsArray = array_map('intval', explode(',', (string) $brand));
        $brandsData = Brand::whereIn('id', $idsArray)->get();
        $groupsCount=[];
        $groupsArray = [];
        foreach ($brandsData as $brandData){
            $countriesIds = is_array($brandData->country_id)?$brandData->country_id:[];
            $dislikesIds = BrandDislike::where('brand_id', $brandData->id)->pluck('influencer_id')->toArray();
            $groups = $this->group->getGroupListsWithInfluencersCountQuery($brandData->id, $countriesIds, $dislikesIds)->get();
            foreach ($groups as $group){
                $groupsArray[] = $group;
                array_push($groupsCount,['group_id'=>$group->id,'count'=>$group->influencer_count, 'brand_name' => $brandData->name]);
            }
        }

        return response()->json(['status'=>true,'data'=>$groupsArray,'groupsCount'=>$groupsCount],200);
    }



    public function groupList_merge_save(Request $request){
        //fixme::groupUpdates
        $brands_group_from=explode(',',$request->brands_from);
        $brands_group_to=$request->brands_to;
        $brand_id = $request->brand_id;
        $brandData = Brand::find((int) $brand_id);
        if(!$brandData){
            return response()->json(['status'=>'false','message'=>"Brand not selected"],500);
        }
        $dislikesIds = BrandDislike::where('brand_id', $brand_id)->pluck('influencer_id')->toArray();

        $influencersGroupsFrom = InfluencerGroup::with('influencer')->whereHas('influencer', function ($q){
            $q->where('influencers.active', 1);
        })->whereIn('group_list_id',$brands_group_from)->whereNotIn('influencer_id', $dislikesIds)->whereNull('deleted_at')->whereNull('group_deleted_at')->get();
        $groupTo=GroupList::where('id',$brands_group_to)->first();
        $success=0;
        $fail=0;
        $authUser = auth()->id();
        if(is_null($brands_group_to)){
            return response()->json(['status'=>'false','message'=>"Brands Select one group"],500);
        }

        $messages_success = [];
            foreach ($influencersGroupsFrom as $influencerGroupFrom){
                $mainInfluencer = $influencerGroupFrom->influencer;
                if(!$mainInfluencer){
                    $messages_success[]=['message'=>'Not found influencer data',"Name"=> "None","status"=>"faild"];
                    $fail++;
                    continue;
                }

                if($groupTo){
                    if(!in_array((int)$mainInfluencer->country_id, (is_array($groupTo->country_id)?$groupTo->country_id:[]))){
                        $fail++;
                        $messages_success[]=['message'=>'outside of groups countries.',"Name"=> $mainInfluencer->name,"status"=>"faild"];
                        continue;
                    }
                    InfluencerGroup::updateOrCreate(['brand_id' => $brand_id, 'influencer_id' => $influencerGroupFrom->influencer_id, 'group_list_id' => $groupTo->id, 'deleted_at' => null, 'group_deleted_at' => null], ['brand_id' => $brand_id, 'date'=>now()->format('Y-m-d'), 'influencer_id' => $influencerGroupFrom->influencer_id, 'group_list_id' => $groupTo->id, 'created_by' => $authUser]);
                    $messages_success[]=["status"=>"success"];
                    $success++;
                }else{
                    if(!in_array((int)$mainInfluencer->country_id, (is_array($brandData->country_id)?$brandData->country_id:[]))){
                        $fail++;
                        $messages_success[]=['message'=>'outside of brand supported countries.',"Name"=> $mainInfluencer->name,"status"=>"faild"];
                        continue;
                    }
                    InfluencerGroup::updateOrCreate(['brand_id' => $brand_id, 'influencer_id' => $influencerGroupFrom->influencer_id, 'group_list_id' => null, 'deleted_at' => null, 'group_deleted_at' => null], ['brand_id' => $brand_id, 'date'=>now()->format('Y-m-d'), 'influencer_id' => $influencerGroupFrom->influencer_id, 'group_list_id' => null, 'created_by' => $authUser]);
                    $messages_success[]=["status"=>"success"];
                    $success++;
                }
            }
        return response()->json(['status' => true, 'message' => $messages_success], 200);
    }

    public function deprecated__groupList_merge_save(Request $request){
		//dd($request->all());
         $brand_user_country=explode(',',$request->brand_user_country);
         $brand_country_select=json_decode($request->brand_country_select);
         $brands_group_from=explode(',',$request->brands_from);
         $brands_group_to=$request->brands_to;
         $brand_select=$request->brand_select;
         $brand_id=$request->brand_id;
     //   if(count(array_intersect($brand_country_select,$brand_user_country))){
           $groupsFrom= GroupList::whereIn('id',$brands_group_from)->get();
           $groupTo=GroupList::where('id',$brands_group_to)->first();
			$success=0;
			$fail=0;
			$authUser = auth()->user();
           if($brands_group_to!=null){
               foreach ($groupsFrom as $group){
                   $brandFavs=BrandFav::whereRaw("JSON_SEARCH( `brand_favorites`.`group_list_id`, 'one','{$group->id}', null, '$[*].list_id' ) IS NOT NULL And JSON_CONTAINS(`brand_favorites`.`group_list_id`, json_object('list_id','{$group->id}','deleted_at',null))")->get();
                   foreach ($brandFavs as $brandFav){
                      if(!$groupTo){
                          BrandFav::updateOrCreate(['brand_id'=>(int)$brand_id,'influencer_id'=>$brandFav->influencer_id, 'deleted_at' => null],
                              ['brand_id'=>(int)$brand_id,'influencer_id'=>$brandFav->influencer_id,'source'=>'INSTAGRAM','date'=>now()->format('Y-m-d')]);
                          $success=$success+1;
                      }else{
                          if(in_array((int)$brandFav->influencers->country_id,$groupTo->country_id)){
                              $newGroupList[] = [
                                  'list_id' => (string) $groupTo->id,
                                  'created_at' => Carbon::now(),
                                  'created_by' => $authUser?(string) $authUser->id:'',
                                  'deleted_at' => null
                              ];
                              $oldBrandFav = BrandFav::where('brand_id', (int)$brand_id)->where('influencer_id', $brandFav->influencer_id)->where('deleted_at', null)->first();
                              if($oldBrandFav && is_array($oldBrandFav->group_list_id)){
                                  $newGroupList = array_merge($oldBrandFav->group_list_id, $newGroupList);
                              }
                               BrandFav::updateOrCreate(['brand_id'=>(int)$brand_id,'influencer_id'=>$brandFav->influencer_id, 'deleted_at' => null],
                                  ['brand_id'=>(int)$brand_id,'influencer_id'=>$brandFav->influencer_id,'source'=>'INSTAGRAM','date'=>now()->format('Y-m-d'), 'group_list_id' => $newGroupList]);

                              $success=$success+1;
                          }else{
                              $fail=$fail+1;
                          }

                      }

                       }
               }

               return response()->json(['status'=>true,'message'=>'Merge Successfully','success'=>$success,'fail'=>$fail]);
           }else{
               return response()->json(['status'=>'false','message'=>"Brands Select one group"],500);
           }
         }

    //}
}
