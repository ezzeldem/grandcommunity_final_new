<?php

namespace App\Http\Controllers\API\BrandDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\BrandDashboard\ContactRequest;
use App\Http\Resources\API\Brand_dashboard\CampaignInfluencersVisitsResource;
use App\Http\Resources\API\Brand_dashboard\InfluencersResource;
use App\Http\Resources\API\CampaignResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\BrandDislike;
use App\Models\BrandFav;
use App\Models\Contact;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Models\User;
use App\Repository\StatisticsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use ResponseTrait;

    public function getStatistics()
    {

        $user = User::find(auth()->user()->id);
        $brand = @$user->brands;
        $country_ids = @auth()->user()->brands->countries()->pluck('id')->toArray();
        $dislikesIds = BrandDislike::where('brand_id', $brand->id)->pluck('influencer_id')->toArray();
        $wishlistCount = Influencer::whereIn('influencers.country_id', $country_ids)
            ->where('influencers.active', 1)
            ->whereNotIn('influencers.id', $dislikesIds)->whereHas('influencerGroups', function ($q) use ($brand) {
            $q->where('influencers_groups.brand_id', $brand->id)
                ->where('influencers_groups.deleted_at', null);
        })->count();

        $statistics = [

            ['id' => 1, 'title' => __('lang.group_of_brands'), 'link' => '/dashboard/$brand/brands', "icon" => 'mdi-medal', 'count' => @$user->brands->subbrands()->count() ?? 0, 'image' => asset('front/images/chat.png'),
            ],

            ['id' => 2, 'title' => __('lang.favorite_influencers'), 'link' => '/dashboard/$brand/wishlist', "icon" => 'mdi-account-group', 'count' => $wishlistCount ?? 0, 'image' => asset('front/images/influencerCard.png'),

            ],
            ['id' => 3, 'title' => __('lang.campaigns'), 'link' => '/dashboard/$brand/campaign/campaign-list', "icon" => 'mdi-bullhorn', 'count' => @$user->brands->campaigns()->count() ?? 0, 'image' => asset('front/images/influencerCard.png'),
            ],
            // ['id'=>4,'title' => __('lang.messages'), 'link' => '/dashboard/$brand/messages', "icon" => 'mdi-comment', 'count' => 0, 'image' => asset('front/images/chat.png'),

            // ],
        ];

		###logs
        $logs = $user->brands->campaigns->map(function ($camp) {
            return $camp->campLogs;
        })->flatten()->paginate(10);


       ###campaignCharts

	   $brandCampaigns = $user->brands->campaigns()->selectRaw('count(campaigns.id) as camp_count');
       $campaignVisitObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0])->first();
	     $campaignVisitCount = ($campaignVisitObj) ? $campaignVisitObj->camp_count : 0;
			$campaignVisitPendingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>0])->first();
			$campaignVisitActiveObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>1])->first();
			$campaignVisitCompletedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>2])->first();
            $campaignVisitCanceledObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>3])->first();
            $campaignVisitUpcomingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>4])->first();
            $campaignVisitDraftedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 0 ,'campaigns.status'=>5])->first();

	   $campaignDeliveryObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1])->first();
	        $campaignDeliveryCount = ($campaignDeliveryObj) ? $campaignDeliveryObj->camp_count : 0;
            $campaignDeliveryPendingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>0])->first();
			$campaignDeliveryActiveObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>1])->first();
			$campaignDeliveryCompletedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>2])->first();
            $campaignDeliveryCanceledObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>3])->first();
            $campaignDeliveryUpcomingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>4])->first();
            $campaignDeliveryDraftedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 1 ,'campaigns.status'=>5])->first();

	   $campaignMixObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2])->first();
			$campaignMixCount = ($campaignMixObj) ? $campaignMixObj->camp_count : 0;
			$campaignMixPendingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2 ,'campaigns.status'=>0])->first();
			$campaignMixActiveObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2,'campaigns.status'=>1])->first();
			$campaignMixCompletedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2 ,'campaigns.status'=>2])->first();
            $campaignMixCanceledObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2 ,'campaigns.status'=>3])->first();
            $campaignMixUpcomingObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2 ,'campaigns.status'=>4])->first();
            $campaignMixDraftedObj = (Clone $brandCampaigns)->where(['campaign_type'=> 2 ,'campaigns.status'=>5])->first();


				$campaignVisitSatictics = [
				    ["name" => __('lang.active_camp'), "count" => ($campaignVisitActiveObj) ? $campaignVisitActiveObj->camp_count : 0],
					["name" => __('lang.pending_camp'), "count" => ($campaignVisitPendingObj) ? $campaignVisitPendingObj->camp_count : 0],
					["name" => __('lang.finished_camp'), "count" => ($campaignVisitCompletedObj) ? $campaignVisitCompletedObj->camp_count : 0],
                    ["name" => __('lang.canceled_camp'), "count" => ($campaignVisitCanceledObj) ? $campaignVisitCanceledObj->camp_count : 0],
                    ["name" => __('lang.upcoming_camp'), "count" => ($campaignVisitUpcomingObj) ? $campaignVisitUpcomingObj->camp_count : 0],
                    ["name" => __('lang.drafted_camp'), "count" => ($campaignVisitDraftedObj) ? $campaignVisitDraftedObj->camp_count : 0],
				];

				$campaignDeliverySatictics = [
				    ["name" => __('lang.active_camp'), "count" => ($campaignDeliveryActiveObj) ? $campaignDeliveryActiveObj->camp_count : 0],
					["name" => __('lang.pending_camp'), "count" => ($campaignDeliveryPendingObj) ? $campaignDeliveryPendingObj->camp_count : 0],
					["name" => __('lang.finished_camp'), "count" => ($campaignDeliveryCompletedObj) ? $campaignDeliveryCompletedObj->camp_count : 0],
                    ["name" => __('lang.canceled_camp'), "count" => ($campaignDeliveryCanceledObj) ? $campaignDeliveryCanceledObj->camp_count : 0],
                    ["name" => __('lang.upcoming_camp'), "count" => ($campaignDeliveryUpcomingObj) ? $campaignDeliveryUpcomingObj->camp_count : 0],
                    ["name" => __('lang.drafted_camp'), "count" => ($campaignDeliveryDraftedObj) ? $campaignDeliveryDraftedObj->camp_count : 0],
				];


				$campaignMixSatictics = [
				    ["name" => __('lang.active_camp'), "count" => ($campaignMixActiveObj) ? $campaignMixActiveObj->camp_count : 0],
					["name" => __('lang.pending_camp'), "count" => ($campaignMixPendingObj) ? $campaignMixPendingObj->camp_count : 0],
					["name" => __('lang.finished_camp'), "count" => ($campaignMixCompletedObj) ? $campaignMixCompletedObj->camp_count : 0],
                    ["name" => __('lang.canceled_camp'), "count" => ($campaignMixCanceledObj) ? $campaignMixCanceledObj->camp_count : 0],
                    ["name" => __('lang.upcoming_camp'), "count" => ($campaignMixUpcomingObj) ? $campaignMixUpcomingObj->camp_count : 0],
                    ["name" => __('lang.drafted_camp'), "count" => ($campaignMixDraftedObj) ? $campaignMixDraftedObj->camp_count : 0],
				];




        $checkedIn = $user->brands->campaigns->map(function ($camp) {
            return $camp->campaignVisitInfluencers;
        })->flatten()->paginate(10);

        $campaigns = $user->brands->campaigns()->whereIn('campaigns.status', [0, 1])->inRandomOrder()->take(10)->get();

        if ($brand = $user->brands) {
            $influencers = Influencer::where('active', 1)->with(['country'])->whereIn('country_id', $brand->country_id)
                ->where(function ($i) {
                    $i->orWhereDoesntHave('dislikes', function ($x) {
                        $x->where('brand_id', @auth()->user()->brands->id);
                    });
                })->inRandomOrder()->take(10)->get();

        } else {
            $influencers = collect();
        }

        $response = collect([
            'status' => true,
            'statistics' => $statistics,
            'campaigns' => CampaignResource::collection($campaigns),
            'logs' => $logs,
            'checkedIn' => CampaignInfluencersVisitsResource::collection($checkedIn),
            'chart_campaing' => [
                'campaigns_status' => [
                    [
                        'status' => __('lang.visit'), //visit
                        'total' => $campaignVisitCount,
                        'count' => $campaignVisitSatictics,
                    ],
                    [
                        'status' => __('lang.delivery'), //delivery
                        'total' => $campaignDeliveryCount,
                        'count' => $campaignDeliverySatictics,
                    ],
                    [
                        'status' => __('lang.mix'), //mix
                        'total' => $campaignMixCount,
                        'count' => $campaignMixSatictics,
                    ],
                ],
            ],
            'influencers' => InfluencersResource::collection($influencers),
        ]);

        return response()->json($response, 200);
    }

    public function getBrandCharts(Request $request)
    {
        $statistics = new StatisticsRepository();
        $type = $request->type;
        $fromDate = isset($request->fromDate) ? $request->fromDate : null;
        $toDate = isset($request->toDate) ? $request->toDate : null;
        switch ($type) {
            case "brands":
                $result = $statistics->getModelBrandSatistics(new Brand, ["fromDate" => $fromDate, "toDate" => $toDate]);
                $data = ['type' => 'Brands', 'result' => $result];
                return response()->json($data, 200);
                break;
            case "branches":
                $result = $statistics->getModelBrandSatistics(new Branch, ["fromDate" => $fromDate, "toDate" => $toDate]);
                $data = ['type' => 'Branches', 'result' => $result];
                return response()->json($data, 200);
                break;
            case "Influencer":
            default:
                $result = $statistics->getModelBrandSatistics(new Influencer, ["fromDate" => $fromDate, "toDate" => $toDate]);
                $data = ['type' => 'Influencer', 'result' => $result];
                return response()->json($data, 200);
                break;
        }

    }

    public function contact_us(ContactRequest $request)
    {
        $contact_data = $request->only(['name', 'phone', 'email', 'message', 'type']);
        Contact::create($contact_data);
        return $this->returnSuccessMessage(__('api.message_send_successfully'));
    }
}
