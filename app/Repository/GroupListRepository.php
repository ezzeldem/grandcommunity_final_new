<?php

namespace App\Repository;

use App\Http\Resources\Admin\InfluencerResource;
use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\BrandFav;
use App\Models\Country;
use App\Models\GroupList;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Models\Subbrand;
use App\Repository\Interfaces\GroupListInterFace;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupListRepository implements GroupListInterFace
{
    public function show($id)
    {
        $groups = GroupList::where('brand_id', $id)->paginate(5);
        foreach ($groups as $group) {
            $group['country_id'] = Country::whereIn('id', array_map('intval', $group['country_id']))->select('id', 'code', 'name')->get();
        }
        return $groups;
    }
    public function create_groups($request)
    {
        if (!$request->has('brand_id'))
            $request['brand_id'] = @auth()->user()->brands->id;

        if ($request['flag'] == "0") {
            $groupss = $request->all();
            $groups = GroupList::find($request['id']);
            $groups->update($groupss);
        } else {

            $brand = Brand::find((int) $request['brand_id']);
            $subrand = Subbrand::find((int) $request->sub_brand_id);
            if ($subrand) {
                $data = array_merge($request->all(), ['sub_brand_id' => (int) $request->sub_brand_id]);
                $data['country_id'] = $subrand->country_id;
                $groups = GroupList::create($data);
            } else {
                $request['country_id'] = $brand->country_id;
                $groups = GroupList::create($request->all());
            }
        }

        $countries = Country::whereIn('id', array_map('intval', $groups['country_id']))->select('code')->get();

        $groups['country_id'] = $countries;
        $groups['ids_country'] = $request->country_id;
        $groups['fav_count'] = ($sl->fav_count) ?? 0;
        $groups['sub_brand_name'] = $groups->sub_brands->name ?? '__';

        return $groups;
    }

    // public function delete_all($request)
    // {
    //     $selected_ids_new = $request->selected_ids;
    //     $Group_list = GroupList::whereIn('id', $selected_ids_new)->get(['id']);

    //     $groups = BrandFav::when($Group_list, function ($query) use ($selected_ids_new) {
    //         $query->where(function ($query) use ($selected_ids_new) {
    //             foreach ($selected_ids_new as $Group) {
    //                 $query->orWhereRaw('JSON_CONTAINS(group_list_id, \'{"list_id": "' . $Group . '","deleted_at":null}\')');
    //             }
    //         });
    //     })->get();

    //     if ((count($groups) > 0)) {
    //         foreach ($selected_ids_new as $key => $id) {
    //             if ($request->delete_option == 0) {
    //                 DB::statement("UPDATE brand_favorites
    //                 SET deleted_at = now() , group_list_id =  JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$id}', null
    //                 , '$[*].list_id' ) , '.list_id' , '' )),
    //                 json_object('list_id','{$id}','created_at',NOW(),'created_by','1','deleted_at',now()))
    //                 WHERE  JSON_SEARCH(group_list_id, 'one','{$id}') IS NOT NULL");
    //             } else {
    //                 $dislike_list =  [
    //                     'brand_id' => $groups[$key]->brand_id,
    //                     'influencer_id' => $groups[$key]->influencer_id,
    //                 ];

    //                 BrandDislike::create($dislike_list);
    //             }
    //         }
    //     }
    //         $Group_list = GroupList::whereIn('id', $selected_ids_new)->delete();
    // }

    public function delete_all($request)
    {
        $selected_ids_new = is_array($request->selected_ids)?$request->selected_ids:[];
        $nowTime = Carbon::now()->format('Y-m-d H:i:s');
        $brandId = ($request['brand_id']??null)?$request['brand_id']:@auth()->user()->brands->id;
        if ($request->delete_option == 1){ //move all to unfavourite [delete all group influencers]
            $groupInfluencersIds = InfluencerGroup::whereIn('group_list_id', $selected_ids_new)->whereNull('deleted_at')->whereNull('group_deleted_at')->pluck('influencer_id');
            InfluencerGroup::where('brand_id', $brandId)->whereIn('influencer_id', $groupInfluencersIds)->whereNull('deleted_at')->update(['deleted_at' => $nowTime, 'group_deleted_at' => $nowTime]);
            GroupList::whereIn('id', $selected_ids_new)->delete();
        }elseif ($request->delete_option == 0){ //move all group influencers to dislike and then soft delete all
            $influencersGroupsIds = InfluencerGroup::whereIn('group_list_id', $selected_ids_new)->whereNull('deleted_at')->whereNull('group_deleted_at')->groupBy('influencer_id')->pluck('brand_id', 'influencer_id')->toArray();
            $influencersGroupsIdsArray = [];
            foreach($influencersGroupsIds as $key => $value){
                $influencersGroupsIdsArray[] = [
                    'brand_id' => $value,
                    'influencer_id' => $key,
                ];
            }
            foreach ($influencersGroupsIdsArray as $influencersGroupsRow){
                BrandDislike::updateOrCreate($influencersGroupsRow, $influencersGroupsRow);
            }

            if(count($influencersGroupsIds) > 0){
                InfluencerGroup::whereIn('influencer_id', array_keys($influencersGroupsIds))->whereNull('deleted_at')->update(['deleted_at' => $nowTime]);
            }
            GroupList::whereIn('id', $selected_ids_new)->delete();
        }elseif ($request->delete_option == 2){ //remove influencers from thier selected groups and then remove groups
            InfluencerGroup::whereIn('group_list_id', $selected_ids_new)->whereNull('deleted_at')->whereNull('group_deleted_at')->update(['group_deleted_at' => $nowTime]);
            GroupList::whereIn('id', $selected_ids_new)->delete();
        }
    }



    public function restore_all($request)
    {
        $selected_ids_new = explode(',', $request->selected_ids);
        $influencers = GroupList::whereIn('id', $selected_ids_new)->restore();

        foreach ($selected_ids_new as $id) {
            $influencer = Influencer::find($id); //->dislikes()->delete();

            $res = DB::statement("UPDATE brand_favorites
            SET group_list_id =
                JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$id}', null, '$[*].list_id' ) , '.list_id' , '' )),
                    json_object('list_id','{$id}','created_at',NOW(),'created_by','1','deleted_at',null))
            WHERE JSON_SEARCH(group_list_id, 'one',{$id}) IS NOT NULL");
        }
        return $influencers;
    }
    public function groupListBrand()
    {
        $filter = \request()->only(['groupId', 'brand_id', 'country_id', 'country_taps', 'custom']);
        $limit = (request('length')) ? (request('length') != "-1" ? request('length') : 5000) : 20;
        $start = \request('start');
        //$group_soft_deleted = GroupList::withTrashed()->find(request()->groupId);
        $query = InfluencerResource::collection(Influencer::doesnthave('dislikes')->ofGroupFilter($filter)->skip($start)->take($limit)->get());
        return $query;
    }

    /**
     * copy or add influencer to wishlist
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $copy_all_id list of influencer ids
	 * @param  array  $choose_group_list list of group ids
	 * @param  boolean  $copy if copy --> true mean copy influencer from group to another one , false add influencer to wishlist
     * @return \Illuminate\Http\Response
     */
    public function copyInflueBrandGroup($request,$copy = true)
    {
        try {
			\DB::beginTransaction();
			$created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
            $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
			$group_ids[] = $request->choose_group_list;
            $influeIds = (!is_array($request->copy_all_id)) ?  explode(',', $request->copy_all_id) : $request->copy_all_id;

			$influencers = Influencer::select('country_id', 'name', 'id','active')->whereIn('id', $influeIds)->whereraw('influencers.id not in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')')->get();
            $Brand_groups =  GroupList::whereIn('id', $request->choose_group_list)->get();
            $failedInfluencerNames = [];
			$total_failed = 0; $total_success =0 ;
            $dislikesInfluencers = BrandDislike::where('brand_id', (int) $brand_id)->pluck('influencer_id')->toArray();

            $all_list_ids = '';$activeInflueIds = [];

            foreach ($influencers as $influ_single) {
				$newcountryupdate = [];
				$activeInflueIds[] = $influ_single->id;
				foreach ($Brand_groups as $single_gr) {
//				  $subBrandCountryIds = isset($single_gr->sub_brands) && !empty($single_gr->sub_brands->country_id) ? $single_gr->sub_brands->country_id : [] ;
				  $subBrandCountryIds = is_array($single_gr->country_id)?$single_gr->country_id:[];
				  $listId = $single_gr->id;
                  /** the influencer is deactived */
				  if((int) $influ_single->active != 1)
				  {
					$total_failed++;
					array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencer_isnot_active')]);
					continue;
				  }

				  if(in_array((int) $influ_single->id, $dislikesInfluencers)){
                      $total_failed++;
                      array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencer_is_disliked')]);
                      continue;
                  }
				  if(!in_array($influ_single->country_id,$subBrandCountryIds))
				  {    $total_failed++;
				       array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencercountry_notmatch')]);
					  continue;
				  }
//                  $brandFav = InfluencerGroup::where('influencer_id', $influ_single->id)->where('brand_id', $brand_id);
//
//					if ($brandFav->exists()){
//                        $brandFav->update(['date' => now(), 'deleted_at' => NULL]);
//                    }else{
//                        Brand::find($brand_id)->influencersFavorites()->syncWithoutDetaching([$influ_single->id => ['date' => now(), 'source' => 'INSTAGRAM','created_at'=>now()]]);
//                    }

                    $updated = InfluencerGroup::updateOrCreate([
                        'influencer_id' => $influ_single->id,
                        'brand_id' => $brand_id,
                        'group_list_id' => $listId,
                        'deleted_at' => null,
                        'group_deleted_at' => null
                    ], [
                        'influencer_id' => $influ_single->id,
                        'brand_id' => $brand_id,
                        'group_list_id' => $listId,
                        'deleted_at' => null,
                        'group_deleted_at' => null
                    ]);
							if (!$updated) {
								$total_failed++;
								array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]);
							} else {
								$total_success++;
								if (!in_array($influ_single->country_id, (array)$single_gr->country_id)) {
									array_push($newcountryupdate, $influ_single->country_id);
									$newcountryupdate = array_map('strval', $newcountryupdate);
									$newarray = array_merge((array)$single_gr->country_id, $newcountryupdate);
									$single_gr->update(['country_id' => $newarray]);
								}
							}
                }
            }

			\DB::commit();
            return [ "messages" => __('api.successfully_added') ,"results" => $failedInfluencerNames,'total_failed'=>$total_failed , 'total_success'=>$total_success ];
        } catch (Exception $e) {
			\DB::rollBack();
            return ["status" => false, "messages" => 'server Error!'];
        }
    }

    public function ___copyInflueBrandGroup($request,$copy = true)
    {
        try {
			\DB::beginTransaction();
			$created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
            $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
			$group_ids[] = $request->choose_group_list;
            $influeIds = (!is_array($request->copy_all_id)) ?  explode(',', $request->copy_all_id) : $request->copy_all_id;

			$influencers = Influencer::select('country_id', 'name', 'id','active')->whereIn('id', $influeIds)->whereraw('influencers.id not in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')')->get();
            $Brand_groups =  GroupList::whereIn('id', $request->choose_group_list)->get();
            $failedInfluencerNames = [];
			$total_failed = 0; $total_success =0 ;


            $all_list_ids = '';$activeInflueIds = [];

            foreach ($influencers as $influ_single) {
				$newcountryupdate = [];
				$activeInflueIds[] = $influ_single->id;
				foreach ($Brand_groups as $single_gr) {
				  $subBrandCountryIds = isset($single_gr->sub_brands) && !empty($single_gr->sub_brands->country_id) ? $single_gr->sub_brands->country_id : [] ;
				  $listId = $single_gr->id;
                  /** the influencer is deactived */
				  if((int) $influ_single->active != 1)
				  {
					$total_failed++;
					array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencer_isnot_active')]);
					continue;
				  }
				  if(!in_array($influ_single->country_id,$subBrandCountryIds))
				  {    $total_failed++;
				       array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencercountry_notmatch')]);
					  continue;
				  }
                  $brandFav = BrandFav::where('influencer_id', $influ_single->id)->where('brand_id', $brand_id);

					if ($brandFav->withTrashed()->exists()):
							$brandFav->update(['date' => now(), 'deleted_at' => NULL]);
					else:
						// if(!$copy){
							Brand::find($brand_id)->influencers()->syncWithoutDetaching([$influ_single->id => ['date' => now(), 'source' => 'INSTAGRAM','created_at'=>now()]]);
						// }else
							// {$total_failed++; array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]); continue;}
					endif;

                    $exists = BrandFav::where(['influencer_id' => $influ_single->id, 'brand_id' => $brand_id])->whereRaw('JSON_CONTAINS(group_list_id, \'{"list_id": "' . $listId . '"}\')')->exists();
                    if ($exists) { ##update group list

                        $updated = DB::statement("UPDATE brand_favorites
                                SET group_list_id =
                                    JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$listId}', null, '$[*].list_id' ) , '.list_id' , '' )),
                                    json_object('list_id','{$listId}','created_at',NOW(),'created_by','{$created_by}','deleted_at',null))
                            WHERE  `brand_id` = '{$brand_id}' AND`influencer_id` = '{$influ_single->id}' and JSON_SEARCH(group_list_id, 'one',{$listId}) IS NOT NULL");
                    }else { ##insert new raw

                        $updated = DB::statement("UPDATE brand_favorites SET  group_list_id = IF(`group_list_id` IS NULL OR JSON_TYPE(`group_list_id`) != 'ARRAY', JSON_ARRAY(),  `group_list_id` )
                            ,group_list_id =    JSON_ARRAY_APPEND(`group_list_id` , '$',json_object('list_id','{$listId}','created_at',NOW(),'created_by','{$created_by}','deleted_at',Null))
                            WHERE `brand_id` = '{$brand_id}' AND`influencer_id` = '{$influ_single->id}' and JSON_SEARCH( `group_list_id`, 'one','{$listId}', null, '$[*].list_id' ) IS NULL;");
                    }
							if (!$updated) {
								$total_failed++;
								array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]);
							} else {
								$total_success++;
								if (!in_array($influ_single->country_id, (array)$single_gr->country_id)) {
									array_push($newcountryupdate, $influ_single->country_id);
									$newcountryupdate = array_map('strval', $newcountryupdate);
									$newarray = array_merge((array)$single_gr->country_id, $newcountryupdate);
									$single_gr->update(['country_id' => $newarray]);
								}
							}
                }
            }

/** influencers blocked by brand */
			if($request->has('brand_id')){
				$faildInfluIds = array_diff($influeIds, $activeInflueIds);
				$dislike_influencers = Influencer::select('country_id', 'name', 'id')->whereIn('id', $faildInfluIds)->where('active',1)->whereraw('influencers.id in (select influencer_id from `brand_dislikes` where `brand_id` = '.$brand_id.')')->get();
				if(!empty($dislike_influencers)){
					foreach($dislike_influencers as $block_influe){
						$total_failed++;
						array_push($failedInfluencerNames, ["Name" => $block_influe->name,"Id"=>$block_influe->id,'Resaon'=>__('api.influencer_is_disliked')]);
					}
				}

			}
			\DB::commit();
            return [ "messages" => __('api.successfully_added') ,"results" => $failedInfluencerNames,'total_failed'=>$total_failed , 'total_success'=>$total_success ];
        } catch (Exception $e) {
			\DB::rollBack();
            return ["status" => false, "messages" => 'server Error!'];
        }
    }


	 /**
     * move infuencer from one group to another one
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $influeIds list of influencer ids
	 * @param  array  $to_groups list of group ids
	 * @param  integer  fromGroups from the current group
     * @return \Illuminate\Http\Response
     */
    public function moveInflueBrandGroup($request,$copy = false)
    {
        try {
			\DB::beginTransaction();
            $influeIds = (!is_array($request->influeIds)) ?  explode(',', $request->influeIds) : $request->influeIds;
            $influencers = Influencer::select('country_id', 'name', 'id')->whereIn('id', $influeIds)->get();
            $to_group_ids[] = $request->to_groups;
            $from_group_id = (is_array($request->fromGroups)) ? $request->fromGroups : (array)$request->fromGroups;
			// $fromGroup = GroupList::find($from_group_id);
			// if(!$fromGroup)
			//     return Response::simple_json(["status" => false, "messages" => 'server Error!']);

            $Brand_groups =  GroupList::whereIn('id', $request->to_groups)->get();
            $failedInfluencerNames = []; $total_failed = 0; $total_success =0 ;

            $created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
            $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
            $all_list_ids = '';
			$newcountryupdate = [];

            foreach ($influencers as $influ_single) {
			 foreach ($Brand_groups as $single_gr) {
				$subBrandCountryIds = isset($single_gr->sub_brands) && !empty($single_gr->sub_brands->country_id) ? $single_gr->sub_brands->country_id : [] ;
				$listId = $single_gr->id;

//				if(!in_array($influ_single->country_id,$subBrandCountryIds))
//				{    $total_failed++;
//					 array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencercountry_notmatch')]);
//					continue;
//				}
                // $brandFav = BrandFav::where('influencer_id', $influ_single->id)->where('brand_id', $brand_id)->whereRaw('JSON_CONTAINS(group_list_id, \'{"list_id": "' . $from_group_id . '"}\')')->exists();
				// 	if(!$brandFav)
				// 	   {$total_failed++; array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]); continue;}

                 $updated = InfluencerGroup::updateOrCreate([
                     'influencer_id' => $influ_single->id,
                     'brand_id' => $brand_id,
                     'group_list_id' => $listId,
                 ], [
                     'influencer_id' => $influ_single->id,
                     'brand_id' => $brand_id,
                     'group_list_id' => $listId,
                     'deleted_at' => null,
                     'group_deleted_at' => null
                 ]);

						if (!$updated) {
							$total_failed++;
							array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]);
						} else {
							$total_success++;
							if (!in_array($influ_single->country_id, (array)$single_gr->country_id)) {
								array_push($newcountryupdate, $influ_single->country_id);
								$newcountryupdate = array_map('strval', $newcountryupdate);
								$newarray = array_merge((array)$single_gr->country_id, $newcountryupdate);
								$single_gr->update(['country_id' => $newarray]);
							}


							foreach($from_group_id as $frm_grpid){
                                $updated = InfluencerGroup::where([
                                    'influencer_id' => $influ_single->id,
                                    'brand_id' => $brand_id,
                                    'group_list_id' => $frm_grpid,
                                ])->update([
                                    'deleted_at' => Carbon::now()->format('Y-m-d'),
                                    'group_deleted_at' => Carbon::now()->format('Y-m-d'),
                                ]);
							}

						}
                }



            }
			\DB::commit();
            return [ "messages" => __('api.successfully_added') ,"results" => $failedInfluencerNames,'total_failed'=>$total_failed , 'total_success'=>$total_success ];
        } catch (Exception $e) {
			\DB::rollBack();
            return Response::simple_json(["status" => false, "messages" => 'server Error!']);
        }
    }

    public function ___moveInflueBrandGroup($request,$copy = false)
    {
        try {
			\DB::beginTransaction();
            $influeIds = (!is_array($request->influeIds)) ?  explode(',', $request->influeIds) : $request->influeIds;
            $influencers = Influencer::select('country_id', 'name', 'id')->whereIn('id', $influeIds)->get();
            $to_group_ids[] = $request->to_groups;
            $from_group_id = (is_array($request->fromGroups)) ? $request->fromGroups : (array)$request->fromGroups;
			// $fromGroup = GroupList::find($from_group_id);
			// if(!$fromGroup)
			//     return Response::simple_json(["status" => false, "messages" => 'server Error!']);

            $Brand_groups =  GroupList::whereIn('id', $request->to_groups)->get();
            $failedInfluencerNames = []; $total_failed = 0; $total_success =0 ;

            $created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
            $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
            $all_list_ids = '';
			$newcountryupdate = [];

            foreach ($influencers as $influ_single) {
			 foreach ($Brand_groups as $single_gr) {
				$subBrandCountryIds = isset($single_gr->sub_brands) && !empty($single_gr->sub_brands->country_id) ? $single_gr->sub_brands->country_id : [] ;
				$listId = $single_gr->id;

				if(!in_array($influ_single->country_id,$subBrandCountryIds))
				{    $total_failed++;
					 array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,'Resaon'=>__('api.influencercountry_notmatch')]);
					continue;
				}
                // $brandFav = BrandFav::where('influencer_id', $influ_single->id)->where('brand_id', $brand_id)->whereRaw('JSON_CONTAINS(group_list_id, \'{"list_id": "' . $from_group_id . '"}\')')->exists();
				// 	if(!$brandFav)
				// 	   {$total_failed++; array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]); continue;}



						$exists = BrandFav::where(['influencer_id' => $influ_single->id, 'brand_id' => $brand_id])->whereRaw('JSON_CONTAINS(group_list_id, \'{"list_id": "' . $listId . '"}\')')->exists();
						if ($exists) { ##update group list
							$updated = DB::statement("UPDATE brand_favorites
									SET group_list_id =
										JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$listId}', null, '$[*].list_id' ) , '.list_id' , '' )),
										json_object('list_id','{$listId}','created_at',NOW(),'created_by','{$created_by}','deleted_at',null))
								WHERE  `brand_id` = '{$brand_id}' AND`influencer_id` = '{$influ_single->id}' and JSON_SEARCH(group_list_id, 'one',{$listId}) IS NOT NULL");
						} else { ##insert new raw
							$updated = DB::statement("UPDATE brand_favorites SET  group_list_id = IF(`group_list_id` IS NULL OR JSON_TYPE(`group_list_id`) != 'ARRAY', JSON_ARRAY(),  `group_list_id` )
								,group_list_id =    JSON_ARRAY_APPEND(`group_list_id` , '$',json_object('list_id','{$listId}','created_at',NOW(),'created_by','{$created_by}','deleted_at',Null))
								WHERE `brand_id` = '{$brand_id}' AND`influencer_id` = '{$influ_single->id}' and JSON_SEARCH( `group_list_id`, 'one','{$listId}', null, '$[*].list_id' ) IS NULL;");
						}


						if (!$updated) {
							$total_failed++;
							array_push($failedInfluencerNames, ["Name" => $influ_single->name,"Id"=>$influ_single->id,"Resaon"=>__('api.server_error')]);
						} else {
							$total_success++;
							if (!in_array($influ_single->country_id, (array)$single_gr->country_id)) {
								array_push($newcountryupdate, $influ_single->country_id);
								$newcountryupdate = array_map('strval', $newcountryupdate);
								$newarray = array_merge((array)$single_gr->country_id, $newcountryupdate);
								$single_gr->update(['country_id' => $newarray]);
							}


							foreach($from_group_id as $frm_grpid){
								$fromInfluencerFromCurrentGroup = DB::statement("UPDATE brand_favorites
								SET group_list_id =
									JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$frm_grpid}', null, '$[*].list_id' ) , '.list_id' , '' )),
									json_object('list_id','{$frm_grpid}','created_at',NOW(),'created_by','{$created_by}','deleted_at',NOW()))
								WHERE  `brand_id` = '{$brand_id}' AND`influencer_id` = '{$influ_single->id}' and JSON_SEARCH(group_list_id, 'one',{$frm_grpid}) IS NOT NULL");
							}

						}
                }



            }
			\DB::commit();
            return [ "messages" => __('api.successfully_added') ,"results" => $failedInfluencerNames,'total_failed'=>$total_failed , 'total_success'=>$total_success ];
        } catch (Exception $e) {
			\DB::rollBack();
            return Response::simple_json(["status" => false, "messages" => 'server Error!']);
        }
    }


     /**
     * remove infuencer or ban
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $influeIds list of influencer ids
	 * @param  integer  $delete_influ_option  0->delete influencer , 1-->ban influencer , 2-->remove from all groups
	 * @param  integer  getGroupID from the current group
     * @return \Illuminate\Http\Response
     */
    public function deleteInflueGroup($request)
    {
       $ids =  (!is_array($request->influencer_ids)) ?  explode(',', $request->influencer_ids) : $request->influencer_ids;
	   $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
	   $created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
	   $influencer_Ids = Influencer::whereIn('id', $ids)->pluck('id')->toArray();
	   $brand = Brand::find($brand_id);
       $all_ids = implode(',',$influencer_Ids);

        switch ((string) $request->delete_influ_option) {
            case "0":  ##delete influencer from all wishlist of brand
                InfluencerGroup::where('brand_id', $brand_id)->whereIn('influencer_id', $influencer_Ids)->whereNull('deleted_at')->update([
                    'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
              break;
			  case "1":	 //dislike influencers
//				   $brand->influencersFavorites()->whereIn('influencers_groups.influencer_id',$influencer_Ids)->delete();
					foreach($influencer_Ids as $infl_ids){
						BrandDislike::updateOrCreate(['brand_id'=>$brand_id,'influencer_id'=>$infl_ids]);
					}

                InfluencerGroup::where('brand_id', $brand_id)->whereIn('influencer_id', $influencer_Ids)->whereNull('deleted_at')->update([
                    'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
			break;
            case "2": ##delete influencer from group IDS
					if (!is_null($request->getGroupID) && $request->getGroupID != 0) {
						if(is_array($request->getGroupID) && !empty($request->getGroupID))
							$groupIds = $request->getGroupID;
						else
						    $groupIds = (array)$request->getGroupID;

                        InfluencerGroup::whereIn('group_list_id', $groupIds)->where('brand_id', $brand_id)->whereIn('influencer_id', $influencer_Ids)->whereNull('deleted_at')->update([
                            'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        ]);
					}
              break;
            case "3":  ##delete influencer from all group
                break; //fixme::delete
//				foreach ($brand->group_lists as $group) {
//				    InfluencerGroup::where('group_list_id', $group->id)->where('brand_id', $brand_id)->whereIn('influencer_id', $influencer_Ids)->whereNull('deleted_at')->update([
//                        'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                    ]);
//				}
                InfluencerGroup::where('brand_id', $brand_id)->whereNotNull('group_list_id')->whereIn('influencer_id', $influencer_Ids)->whereNull('deleted_at')->update([
                    'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
//				$brand->favouritesInfluencer()->whereIn('brand_favorites.influencer_id',$influencer_Ids)->delete();
                break;
             default:
             break;
          }
    }

    public function ___deleteInflueGroup($request)
    {
        $ids =  (!is_array($request->influencer_ids)) ?  explode(',', $request->influencer_ids) : $request->influencer_ids;
        $brand_id = ($request->has('brand_id')) ?  $request->brand_id : @auth()->user()->brands->id;
        $created_by = $request->has('created_by') ?   $request->created_by : @auth()->user()->brands->id;
        $influencer_Ids = Influencer::whereIn('id', $ids)->pluck('id')->toArray();
        $brand = Brand::find($brand_id);
        $all_ids = implode(',',$influencer_Ids);

        switch ($request->delete_influ_option) {
            case "0":  ##delete influencer from all group
                foreach ($brand->group_lists as $group) {
                    $res = DB::statement("UPDATE brand_favorites
						SET group_list_id =
							JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$group->id}', null, '$[*].list_id' ) , '.list_id' , '' )),
								json_object('list_id','{$group->id}','created_at',NOW(),'created_by','1','deleted_at',now()))
						WHERE JSON_SEARCH(group_list_id, 'one',{$group->id}) IS NOT NULL and `influencer_id` in({$all_ids})");
                }
                $brand->favouritesInfluencer()->whereIn('brand_favorites.influencer_id',$influencer_Ids)->delete();
                break;
            case "1":	 //dislike influencers
                $brand->favouritesInfluencer()->whereIn('brand_favorites.influencer_id',$influencer_Ids)->delete();
                foreach($influencer_Ids as $infl_ids){
                    BrandDislike::updateOrCreate(['brand_id'=>$brand_id,'influencer_id'=>$infl_ids]);
                }
                break;
            case "2": ##delete influencer from group IDS
                if (!is_null($request->getGroupID) && $request->getGroupID != 0) {
                    if(is_array($request->getGroupID) && !empty($request->getGroupID))
                        $groupIds = $request->getGroupID;
                    else
                        $groupIds = (array)$request->getGroupID;

                    foreach($groupIds as $group_id){
                        DB::statement("UPDATE brand_favorites
										SET  group_list_id =  JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$group_id}', null
										, '$[*].list_id' ) , '.list_id' , '' )),
										json_object('list_id','{$group_id}','created_at',NOW(),'created_by','{$created_by}','deleted_at',now()))
										WHERE `influencer_id` in({$all_ids}) AND brand_id = {$brand_id} AND JSON_SEARCH(group_list_id, 'one','{$group_id}') IS NOT NULL");
                    }
                }
                break;
            default:
                break;
        }
    }


    public function deleteDislikeInflueGroup($request)
    {
        $influencers = Influencer::whereIn('id', explode(',', $request->influencer_ids))->get();
        foreach ($influencers as $influencer) {
            if (!$influencer->dislikes()->exists()) {
                $influencer->dislikes()->create(['brand_id' => $request->brand_id]);
            }
        }

        if (!is_null($request->getGroupID) && $request->getGroupID != 0) {
            InfluencerGroup::where('group_list_id', $request->getGroupID)->whereIn('influencer_id', $request->influencer_ids)->whereNull('group_deleted_at')->update([
                'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        } else {
            $brand = Brand::find($request->brand_id);
            foreach ($brand->group_lists as $group) {
                InfluencerGroup::where('group_list_id', $group->id)->whereIn('influencer_id', $request->influencer_ids)->whereNull('group_deleted_at')->update([
                    'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

            }
        }
    }

    public function ___deleteDislikeInflueGroup($request)
    {
        $influencers = Influencer::whereIn('id', explode(',', $request->influencer_ids))->get();
        foreach ($influencers as $influencer) {
            if (!$influencer->dislikes()->exists()) {
                $influencer->dislikes()->create(['brand_id' => $request->brand_id]);
            }
        }

        if (!is_null($request->getGroupID) && $request->getGroupID != 0) {
            $groups = GroupList::find($request->getGroupID);
            $res = DB::statement("UPDATE brand_favorites
            SET group_list_id =
                JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$groups->id}', null, '$[*].list_id' ) , '.list_id' , '' )),
                    json_object('list_id','{$groups->id}','created_at',NOW(),'created_by','1','deleted_at',now()))
            WHERE JSON_SEARCH(group_list_id, 'one',{$groups->id}) IS NOT NULL and `influencer_id` in({$request->influencer_ids})");
        } else {
            $brand = Brand::find($request->brand_id);
            foreach ($brand->group_lists as $group) {
                $res = DB::statement("UPDATE brand_favorites
            SET group_list_id =
                JSON_REPLACE( group_list_id,JSON_UNQUOTE(REPLACE( JSON_SEARCH( `group_list_id`, 'all','{$group->id}', null, '$[*].list_id' ) , '.list_id' , '' )),
                    json_object('list_id','{$group->id}','created_at',NOW(),'created_by','1','deleted_at',now()))
            WHERE JSON_SEARCH(group_list_id, 'one',{$group->id}) IS NOT NULL and `influencer_id` in({$request->influencer_ids})");
            }
        }
    }

    public function getGroupListsWithInfluencersCountQuery($brandId, $countriesIds = [], $dislikesIds = [], $type = "fav")
    {
        $groupsQuery = GroupList::where('group_lists.brand_id', (int) $brandId)->withCount(['influencers as influencer_count' => function($query) use ($type, $brandId, $countriesIds, $dislikesIds) {
            $query->select(DB::raw('COUNT(DISTINCT influencers.id)'))->whereHas('influencerGroups', function ($q) use ($type, $countriesIds, $dislikesIds, $brandId) {
                $q->where('influencers_groups.brand_id', (int) $brandId)
                    ->whereColumn('influencers_groups.group_list_id', '=', 'group_lists.id')
                    ->whereNull('influencers_groups.deleted_at');
                if($type == "fav"){
                    $q->whereNull('influencers_groups.group_deleted_at');
                }else{
                    $q->whereNotNull('influencers_groups.group_deleted_at');
                }
            });
            $query->where('influencers.active',1)
			->whereraw('influencers_groups.influencer_id not in (select influencer_id from brand_dislikes where brand_id = '.$brandId.')');
               // ->whereNotIn('influencers.id', $dislikesIds);
            if(count($countriesIds) > 0){
                $query->whereIn('influencers.country_id', $countriesIds);
            }
        }]);
        return $groupsQuery;
    }

}
