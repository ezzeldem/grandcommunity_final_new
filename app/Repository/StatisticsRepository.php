<?php
namespace App\Repository;

use App\Models\Brand;
use App\Models\Influencer;
use App\Models\Campaign;
use App\Models\CampaignCountryFavourite;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Validators\ValidationException;

class StatisticsRepository
{


    public function getModelData(){

    }

    function getModelSatistics($model, $dates = ['start_date' =>null ,'end_date'=>null],$status=null )
    {
     $status = $status;
     $fromDate = ($dates['start_date']) != null ? Carbon::parse($dates['start_date']) : null ;
     $toDate = ($dates['end_date']) != null ? Carbon::parse($dates['end_date']) :null ;


        $result=[];


       /* search parameter */

       // $numberOfAdded = $toDate->diffInDays($fromDate);

        switch(class_basename($model)){
              case "Campaign":
                  $FilterData =['status_val'=>$status,'start_date'=>$fromDate,'end_date'=>$toDate];

                  $all_active_country = Country::where('active',1)->get(['id','name']);
                    $all_data =[];

                    foreach($all_active_country as $country){
                        $country_name = $country->name;

                        $mainQuery = Campaign::whereHas('campaignCountries', function ($q2) use ($country) {
                            $q2->where('country_id', $country->id);
                        })->when($status, function ($q) use ($status) {
                            $q->where('status', $status);
                        })->when($fromDate, function ($q) use ($fromDate) {
                            $q->where(function ($q2) use ($fromDate) {
                               $q2->where('visit_start_date', '>=', $fromDate)->orWhere('deliver_start_date', '>', $fromDate);
                            });
                        })->when($toDate, function ($q) use ($toDate) {
                            $q->where(function ($q2) use ($toDate) {
                               $q2->where('visit_end_date', '<=', $toDate)->orWhere('visit_end_date', '>', $toDate);
                            });
                        });

                        $visit_count = (clone $mainQuery)->where('campaign_type', "0")->whereNull('deleted_at')->count();

                        $delivery_count = (clone $mainQuery)->where('campaign_type', "1")->whereNull('deleted_at')->count();

                        $mix_count = (clone $mainQuery)->where('campaign_type', "2")->whereNull('deleted_at')->count();

                        $share_count = (clone $mainQuery)->where('campaign_type', "3")->whereNull('deleted_at')->count();

                        $post_count = (clone $mainQuery)->where('campaign_type', "4")->whereNull('deleted_at')->count();

                        $all_data[$country_name] = ['visit_count'=>$visit_count ,'delivery_count'=>$delivery_count,'mix_count'=>$mix_count, 'share_count'=>$share_count, 'post_count'=>$post_count];
                    }
              $result['all_data']=$all_data;
              break;
              case "Influencer":

                $FilterData =['status_val'=>$status,'start_date'=>$fromDate,'end_date'=>$toDate];
                $all_active_country = Country::where('active',1)->get(['id','name']);
                $all_data = [];
                foreach($all_active_country as $j=>$country){
                       $influencer_object = clone(Influencer::OfFilter($FilterData)->where('country_id',$country->id));
                        $country_name = $country->name;
                        $active_count = $influencer_object->where('active',1)->count();
                        $in_active_count = $influencer_object->where('active',0)->count();

                          $all_data[$country_name] = ['active_count'=>$active_count ,'in_active_count'=>$in_active_count];
                }
                    $result['all_data'] =$all_data;
              break;
              case "Brand":
                $FilterData =['status_val'=>$status,'start_date'=>$fromDate,'end_date'=>$toDate];

                $all_active_country = Country::where('active',1)->get(['id','name']);
                 $all_data =[];
                foreach($all_active_country as $j=>$country){
                    $brand_object = clone(Brand::OfFilter($FilterData)->where('country_id',$country->id));
                     $country_name = $country->name;
                     $active_count = $brand_object->where('status',1)->count();
                     $in_active_count = $brand_object->where('status',0)->count();

                     $all_data[$country_name] = ['active_count'=>$active_count ,'in_active_count'=>$in_active_count];
             }
                 $result['all_data'] =$all_data;
              default:
              break;
        }


        return $result;
    }


   function getCountrywithStatus($status){

   }

    function getModelBrandSatistics($model, $dates = ['fromDate' =>null ,'toDate'=>null ])
    {
        $result=[];
        $user = User::find(auth()->user()->id);
        $brand=@$user->brands;

        $fromDate = ($dates['fromDate']) ? Carbon::parse($dates['fromDate']) : Carbon::now()->startOfDay()->subMonth() ;
        $toDate = ($dates['toDate']) ? Carbon::parse($dates['toDate']) : Carbon::now(); ;
       /* search parameter */

        $numberOfAdded = $toDate->diffInDays($fromDate);
        $result =[];
        switch(class_basename($model)){
              case "Influencer":
                for ($x = $numberOfAdded ; $x > -1; $x--) {
                      $searchDate = Carbon::parse($toDate)->subDays($x)->format('Y-m-d');

                        $total_influencer =  $user->brands->influencers()->where(['brand_favorites.date'=>$searchDate,"influencers.active"=>1])->count();
                        $influencer_visit_query = $user->brands->campaignBrandInfluencers()->where(['campaign_influencers.status'=>2,'campaign_influencers.campaign_type'=>0])->whereHas('CampaignInfluencerVisit',function($q) use ($searchDate){
                                                      $q->where('actual_date',$searchDate)->groupby('campaign_influencer_visits.campaign_influencer_id');
                                               });
                        $visited =(clone $influencer_visit_query)->where(['campaign_influencers.status'=>2,'campaign_influencers.campaign_type'=>0])->count();
                        $delivered =(clone $influencer_visit_query)->where(['campaign_influencers.status'=>2,'campaign_influencers.campaign_type'=>1])->count();

                      $result[] =  ["date" =>$searchDate , "total" => $total_influencer , 'visit' => $visited , 'delivered' =>$delivered ];
                   }

              break;

              case "Brand":
                for ($x = $numberOfAdded ; $x > -1; $x--) {
                      $searchDate = Carbon::parse($toDate)->subDays($x)->format('Y-m-d');
                        $total =  $user->brands->subbrands()->whereDate('subbrands.created_at',$searchDate)->count();
                        $result[] =  ["date" =>$searchDate , "total" => $total ];
                   }

              break;

              case "Branch":
                for ($x = $numberOfAdded ; $x > -1; $x--) {
                      $searchDate = Carbon::parse($toDate)->subDays($x)->format('Y-m-d');
                      $total =  $user->brands->branchs()->whereDate('branches.created_at',$searchDate)->count();
                      $result[] =  ["date" =>$searchDate , "total" => $total  ];
                   }

              break;

              default:
              break;
        }


        return $result;
    }

}
