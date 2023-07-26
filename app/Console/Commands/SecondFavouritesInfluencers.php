<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\BrancheCampaign;
use App\Models\Brand;
use App\Models\BrandFav;
use App\Models\CampaignCountryFavourite;
use App\Models\CampaignInfluencer;
use App\Models\CampaignInfluencerVisit;
use App\Models\CampaignSecret;
use App\Models\ComplimentCampaign;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\InfluencerGroup;
use App\Models\Subbrand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SecondFavouritesInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-favourites-influencer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //ALTER TABLE `brand_favorites` ADD `go_to_new` INT NULL DEFAULT NULL AFTER `id`;
        //php /home/grandcp3/public_html/admins-grand-community-com/artisan app:new-favourites-influencer
//        ->where(function ($q){
//        $q->where('group_list_id', null)->orWhere('group_list_id', '[]')->orWhere('group_list_id', '');
//    })
       $brandFavourites = BrandFav::where('go_to_new', null)->where('deleted_at', null)->take(1000)->get();
        $newData = [];
       $oldIds = [];
       foreach ($brandFavourites as $brandFavourite){
           $oldIds[] = $brandFavourite->id;
           $hasGroup = false;
           foreach ((is_array($brandFavourite->group_list_id)?$brandFavourite->group_list_id:[]) as $group){
               if(!isset($group['list_id'])){
                   continue;
               }

               if((int) $group['list_id'] <= 0){
                   continue;
               }

               $hasGroup = true;
               $currentBrandFavourites = [
                       'influencer_id' => (int) $brandFavourite->influencer_id,
                       'brand_id' => (int) $brandFavourite->brand_id,
                       'date' => $group['created_at']??$brandFavourite->created_at,
                       'created_at' => $group['created_at']??$brandFavourite->created_at,
                       'deleted_at' => !empty($group['deleted_at'])?$group['deleted_at']:null,
                       'source' => 'INSTAGRAM',
                       'group_list_id' => (int) $group['list_id'],
                       'group_deleted_at' => !empty($group['deleted_at'])?$group['deleted_at']:null,
                       'created_by' => isset($group['created_by'])?(int) $group['created_by']:null,
               ];

               $newData[] = $currentBrandFavourites;
           }

           if(!$hasGroup){
               $newData[] = [
                   'influencer_id' => (int) $brandFavourite->influencer_id,
                   'brand_id' => (int) $brandFavourite->brand_id,
                   'date' => $brandFavourite->date?$brandFavourite->date->format('Y-m-d H:i:s'):null,
                   'created_at' => $brandFavourite->created_at,
                   'deleted_at' => $brandFavourite->deleted_at,
                   'source' => 'INSTAGRAM',
                   'group_list_id' => null,
                   'group_deleted_at' => null,
                   'created_by' => null,
               ];
           }

//           InfluencerGroup::create($newData);
       }

       DB::table('influencers_groups')->insert($newData);
       DB::table('brand_favorites')->whereIn('id', $oldIds)->update(['go_to_new' => 1]);
        $this->info("Campaigns updated successfully Influencers:");
        return true;
    }
}
