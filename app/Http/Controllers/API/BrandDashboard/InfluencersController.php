<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Exports\InstagramLogsExport;
use App\Exports\SnapchatLogsExport;
use App\Exports\TiktokLogsExport;
use App\Exports\TwitterLogsExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Brand_dashboard\InfluencersListResource;
use App\Http\Resources\API\Brand_dashboard\InfluencersResource;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\SocialScrape\CompareTrait;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;
use App\Http\Traits\SocialScrape\SnapchatScrapeTrait;
use App\Http\Traits\SocialScrape\TiktokScrapeTrait;
use App\Http\Traits\SocialScrape\TwitterScrapeTrait;
use App\Models\BrandFav;
use App\Models\Influencer;
use App\Models\InfluencerClassification;
use App\Models\InfluencerGroup;
use App\Models\InfluencerRate;
use App\Models\Interest;
use App\Models\Job;
use App\Models\Language;
use App\Models\User;
use App\Repository\Interfaces\InfluencerInterface;
use App\Repository\StaticDataInfluencerRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class InfluencersController extends Controller
{
    protected $influencer;
    use ResponseTrait, InstagramScrapeTrait, SnapchatScrapeTrait, CompareTrait, TiktokScrapeTrait, TwitterScrapeTrait;

    public function __construct(InfluencerInterface $influencer)
    {
        $this->influencer = $influencer;
    }

    public function getFilterInfluencerData()
    {
        $staticFilterDataRepo = new StaticDataInfluencerRepository();
        $data = [
            'lifeStyle' => $staticFilterDataRepo->ethinkCategory(),
            'citizenStatus' => $staticFilterDataRepo->citizenStatus(),
            'classification' => InfluencerClassification::where('status', 'classification')->get(['id', 'name']),
            'accountType' => $staticFilterDataRepo->accountType(),
            'platForm' => $staticFilterDataRepo->socialCoverage(),
            'rating' => $staticFilterDataRepo->ratingArr(),
            'martialStatus' => $staticFilterDataRepo->getInfluencerMartialStatus(),
            'interests' => Interest::whereStatus(1)->select('id', 'interest')->get(),
            'languags' => Language::whereStatus(1)->get(),
            'jobs' => Job::select('id', 'name')->whereStatus(1)->get(),
            "sort_by" => $staticFilterDataRepo->SortBY(),
            "category" => InfluencerClassification::where('status', 'category')->get(['id', 'name']),
        ];

        return $this->returnData('data', $data, 'influencers data');
    }

    public function brandInfluencers()
    {
        $user = auth()->user();
        $randomOrder = \request()->get('randomOrder');
        $limit = \request('limit');
        if ($limit == -1) {
            $limit = Influencer::count();
        }
        if ($user->type == 0 && $brand = $user->brands) {
            $influencers = Influencer::where('active', 1)
                ->with(['country'])
                ->when($randomOrder && $randomOrder == "true", function ($q) use ($randomOrder) {
                    $q->inRandomOrder();
                })
                ->whereIn('country_id', $brand->country_id)
                ->ofSocialFilter(\request()->except(['limit', 'page']))
                ->paginate(intVal($limit) ?? 20);
            $data['influencers'] = InfluencersListResource::collection($influencers);
            $data['countries'] = $user->brands->countries;

            return $this->returnData('data', $data, 'influencers data');
        } else {
            return $this->returnError(null, __('api.access_denied'));
        }
    }

    public function getAllInfluencers(Request $request)
    {

        // dd($request);


        $limit = $request->get('limit') ? $request->get('limit') : 20;
        $auth_country_ids = @auth()->user()->brands->countries()->pluck('id')->toArray();
        $country_ids = [];

        if (isset($request->country_id) && is_array($request->country_id)) {
            foreach ($request->country_id as $single) {
                if (in_array($single, $auth_country_ids)) {
                    $country_ids[] = $single;
                }
            }
        } elseif (isset($request->country_id) && !is_array($request->country_id)) {
            if (in_array($request->country_id, $auth_country_ids)) {
                $country_ids[] = $request->country_id;
            }
        } else {
            $country_ids = $auth_country_ids;
        }

        if (isset($request->multi_country_id) && is_array($request->multi_country_id)) {
            foreach ($request->multi_country_id as $si_co) {
                if (in_array($si_co, $auth_country_ids)) {
                    $country_ids[] = $si_co;
                }
            }
        }

        $data = $request->except('page', 'limit');
        $filter = $request->only('name_search');

        $influencers = clone (Influencer::select(
            'influencers.id',
            'influencers.insta_uname',
            'influencers.snapchat_uname',
            'influencers.facebook_uname',
            'influencers.twitter_uname',
            'influencers.tiktok_uname',
            'influencers.name',
            'influencers.country_id',
            'influencers.date_of_birth',
            'influencers.interest',
            'influencers.nationality',
            'influencers.gender',
            'influencers.marital_status',
            'influencers.category_ids',
            'influencers.user_id',
            'influencers.created_at'
        )->where('influencers.active', 1)->with(['country']));

        if (count($country_ids) > 0) {
            $influencers = $influencers->whereIn('influencers.country_id', $country_ids);
        }

        if (!empty($data) && count($data) > 0) {
            $influencers = $influencers->ofFilter($filter)->newBrandFavFilter($request)->Seach($request)->distinct()->groupBy('influencers.id')->paginate($limit);
        } else {
            if ($request->get('page') == 1) {
                Cache::forget('excluded_influencer_ids');
            }
            $excludedInfluencerIDs = Cache::get('excluded_influencer_ids', []);
            $influencersCount = $influencers->ofFilter($filter)
                ->newBrandFavFilter($request)->distinct()->count();
            $influencers = $influencers->ofFilter($filter)
                ->newBrandFavFilter($request)
                ->Seach($request)
                ->distinct()
                ->groupBy('influencers.id')
                ->whereNotIn('influencers.id', $excludedInfluencerIDs)
                ->inRandomOrder()
                ->paginate($limit);

            $influencerIds = $influencers->pluck('id')->toArray();
            $allInfluencerIDs = array_merge($excludedInfluencerIDs, $influencerIds);
            Cache::put('excluded_influencer_ids', $allInfluencerIDs, now()->addDay());
        }

        $paginateInfluencers = $influencers->toArray();
        $data['last_page'] = $paginateInfluencers['last_page'];
        $data['total'] = $influencersCount ?? $paginateInfluencers['total'];
        $data['per_page'] = $paginateInfluencers['per_page'];
        $data['data'] = InfluencersResource::collection($influencers);
        return $this->returnData('data', $data, 'influencers data');
    }

    public function favToggle(Influencer $influencer, Request $request)
    {
        $user = auth()->user();
        $brand = $user->brands;
         $influencerGroups = InfluencerGroup::where(['influencer_id'=>(int)$influencer->id ,'brand_id'=>(int) $brand->id])->withTrashed()->get(); //whereNULL('group_list_id')->
        if($influencerGroups->count() > 0){
            $data = [];
            $added = false;
            foreach ($influencerGroups as $influencerGroup){
                if($added){
                    $influencerGroup->forceDelete();
                    continue;
                }
                if($influencerGroup->trashed()){
                    $influencerGroup->update(['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'date'=>Carbon::now()->format('Y-m-d H:i:s'),'deleted_at' => NULL, 'group_deleted_at' => NULL, 'group_list_id' => null]);
                    $data['fav'] = true;
                    $data['total_fav'] = $this->getTotalUserFavorite($brand->id);
                }else{
                    $influencerGroup->update(['created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'), 'group_deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
                    $data['fav'] = false;
                    $data['total_fav'] = $this->getTotalUserFavorite($brand->id);
                }
                $added = true;
            }

            if($data['fav']){
                return $this->returnData('data', $data, __('api.added to fav successfully'));
            }else{
                return $this->returnData('data', $data, __('api.removed from fav successfully'));
            }

        }
        InfluencerGroup::create(['brand_id' => (int) $brand->id, 'influencer_id' => (int) $influencer->id, 'source' => 'INSTAGRAM', 'date' => now()]);
        $data['fav'] = true;
        $data['total_fav'] = $this->getTotalUserFavorite($brand->id);
        return $this->returnData('data', $data, __('api.added to fav successfully'));
    }

    protected function getTotalUserFavorite($brand_id)
    {

        $total = InfluencerGroup::selectRaw("count(Distinct(influencers_groups.influencer_id)) as count_fav ")
            ->join('influencers', 'influencers.id', '=', 'influencers_groups.influencer_id')
            ->where("influencers_groups.brand_id", $brand_id)
            ->whereIn('influencers.country_id', function ($query) use ($brand_id) {
                $query->select('country_id')
                    ->from('brand_countries')
                    ->where('brand_id', $brand_id);
            })->where('influencers.active', 1)->whereNUll('influencers.deleted_at')
            ->whereraw('influencers_groups.influencer_id not in (select influencer_id from brand_dislikes where brand_id = ' . $brand_id . ')')
            ->first();

        return ($total) ? $total->count_fav : 0;
    }
    public function dislikeToggle(Influencer $influencer)
    {
        $user = auth()->user();
        if ($brand = $user->brands) {
            $influencer_dislike = $influencer->dislikes()->where('brand_id', $brand->id);
            $influencer_brand = $influencer->brandsFavorites()->where('influencers_groups.brand_id', $brand->id);
            if ($influencer_dislike->exists()) {
                $influencer_dislike->delete();
                return $this->returnData('dislike', false, __('api.removed from disliked successfully'));
            } else {
                if ($influencer_brand->exists()) {
                    $influencer->brandsFavorites()->syncWithoutDetaching([$brand->id => ['deleted_at' => now(), 'group_list_id' => null]]);
                }
                $influencer->dislikes()->create(['brand_id' => $brand->id]);
                return $this->returnData('dislike', true, __('api.added to disliked successfully'));
            }
        } else {
            return $this->returnError(null, __('api.access_denied'));
        }
    }

    public function dislikeToggleAll(Request $request)
    {
        $user = auth()->user();
        if ($brand = $user->brands) {
            foreach ($request->ids as $influencer) {
                $influencerData = Influencer::find($influencer);
                $influencer_dislike = $influencerData->dislikes()->where('brand_id', $brand->id);
                if ($influencer_dislike->exists()) {
                    $influencer_dislike->delete();
                } else {
                    $influencer_brand = $influencerData->brandsFavorites()->where('influencers_groups.brand_id', $brand->id);
                    if ($influencer_brand->exists()) {
                        $influencerData->brandsFavorites()->syncWithoutDetaching([$brand->id => ['deleted_at' => now(), 'group_list_id' => null]]);
                    }
                    $influencerData->dislikes()->create(['brand_id' => $brand->id]);
                }
            }
            return $this->returnData('data', true, __('api.done_successfully'));
        } else {
            return $this->returnError(null, __('api.access_denied'));
        }
    }

    public function bulkFavToggle(Request $request)
    {
        $user = auth()->user();
        $brand = $user->brands;

        if ($request['fav_toggle'] == 'unfav') {
            InfluencerGroup::whereIn('influencer_id', $request['ids'])
                ->where('brand_id', @$brand->id)
                ->update(['deleted_at' => now()]);

            return $this->returnSuccessMessage(__('api.unfavourite_successfully'));
        } else {
            foreach ($request['ids'] as $id) {
                $brandFav = InfluencerGroup::where('influencer_id', $id)->where('brand_id', $brand->id);
                if ($brandFav->whereNotNull('deleted_at')->exists()) {
                    $brandFav->update(['deleted_at' => null]);
                } else {
                    $brand->influencersFavorites()->syncWithoutDetaching([
                        $id => [
                            'date' => now(),
                            'source' => 'INSTAGRAM',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ]);
                }
            }

            return $this->returnSuccessMessage(__('api.favourite_successfully'));
        }
    }

    public function getInfluencerProfile(Influencer $influencer)
    {
        if (!$influencer) {
            return $this->returnError(null, __('api.influencer does not exist'));
        }

        $data['influencer'] = new InfluencersResource($influencer);

        return $this->returnData('data', $data, 'influencers data');
    }

    public function scrap_insta(Influencer $influencer)
    {
        //  try {
        if (!$influencer) {
            return $this->returnError(null, __('api.influencer does not exist'));
        }

        $data = $this->scrapInstagram($influencer);
        return $this->returnData('data', $data, 'influencers data');
        //  } catch (\Exception $e) {
        //      return response()->json(['status' => false], 500);
        // }
    }

    public function scrap_snap(Influencer $influencer)
    {
        try {
            if (!$influencer) {
                return $this->returnError(null, __('api.influencer does not exist'));
            }

            $data = $this->scrapeSnap($influencer);
            return $this->returnData('data', $data, 'influencers data');
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function scrap_tiktok(Influencer $influencer)
    {
        try {
            if (!$influencer) {
                return $this->returnError(null, __('api.influencer does not exist'));
            }

            $data = $this->scrapeTiktok($influencer);
            return $this->returnData('data', $data, 'influencers data');
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function scrap_Twitter(Influencer $influencer)
    {
        try {
            if (!$influencer) {
                return $this->returnError(null, __('api.influencer does not exist'));
            }

            $data = $this->scrapTwitter($influencer);
            return $this->returnData('data', $data, 'influencers data');
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function compare_users(Request $request)
    {
        try {
            $data = $this->InstaCompare($request);
            return response()->json(['status' => true, 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function rate_influencer(Request $request)
    {
        $user_id = auth()->user()->brands->id;

        $data = InfluencerRate::updateOrCreate(["brand_id" => $user_id, "influencer_id" => $request->inflId], [
            "brand_id" => $user_id, "influencer_id" => $request->inflId, "rate" => $request->rateinfl, "comment_rate" => $request->comment_rate,
        ]);
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    public function getBrandInfluencers(Request $request)
    {
        $user = auth()->user();
        $brand = auth()->user()->brands;
        if ($request->has('search') && !is_null($request->has('search'))) {
            $influencers = $brand->influencers()
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->pluck('name', 'influencers.id');
        } else {
            $influencers = $brand
                ->influencers()
                ->pluck('name', 'influencers.id');
        }
        $data['influencers'] = $influencers;
        $data['countries'] = $user->brands->countries;
        return response()->json(['status' => true, 'data' => $data], 200);
    }

    public function instagramLogsExport(Request $request){
        try {
            return Excel::download(new InstagramLogsExport($request), 'InstagramLogs.xlsx');
        } catch (\Exception $e) {
            return response()->json(['status' => false], 500);
        }
    }

    public function tiktokLogsExport(Request $request){
        try{
            return Excel::download(new TiktokLogsExport($request), 'TiktokLogs.xlsx');
        }catch(\Exception $e){
            return response()->json(['status' => false], 500);
        }
    }

    public function twitterLogsExport(Request $request){
        try{
            return Excel::download(new TwitterLogsExport($request), 'TwitterLogs.xlsx');
        }catch(\Exception $e){
            return response()->json(['status' => false], 500);
        }
    }

    public function snapchatLogsExport(Request $request){
        try{
            return Excel::download(new SnapchatLogsExport($request), 'SnapchatLogs.xlsx');
        }catch(\Exception $e){
            return response()->json(['status' => false], 500);
        }
    }
}
