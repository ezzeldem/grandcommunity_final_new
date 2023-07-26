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
use App\Models\GroupList;
use App\Models\GroupListsFavourits;
use App\Models\Influencer;
use App\Models\Subbrand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class FavouritesInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:favourites-influencer {country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $countryId = null;
    protected $currency = null;
    protected $addGroups = false;
    protected $addFavourites= false;



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //ALTER TABLE `favourite_group_list` ADD `new_id` BIGINT NULL DEFAULT NULL AFTER `id`;
        //ALTER TABLE `favorites` ADD `go_to_new` TINYINT NOT NULL DEFAULT '0' AFTER `id`;


        //php /home/grandcp3/public_html/admins-grand-community-com/artisan app:favourites-influencer 112 >> /dev/null 2>&1

        //last 111389


        $countryId = $this->argument('country');
        $this->countryId = $countryId;

        $countriesList = [21 => ['currency' => 'BHD', 'db' => 'bah'], 59 => ['currency' => 'EGP', 'db' => 'egypt'], 97 => ['currency' => 'IQD', 'db' => 'iraq'], 102 => ['currency' => 'JOD', 'db' => 'jo'], 178 => ['currency' => 'SAR', 'db' => 'ksa'], 112 => ['currency' => 'KWD', 'db' => 'kw'], 126 => ['currency' => 'MAD', 'db' => 'moroc'], 159 => ['currency' => 'OMR', 'db' => 'oman'], 173 => ['currency' => 'QAR', 'db' => 'qatar'], 207 => ['currency' => 'TRY', 'db' => 'tk'], 2 => ['currency' => 'AED', 'db' => 'uae'], 71 => ['currency' => 'GBP', 'db' => 'uk']];
        if(!key_exists($countryId, $countriesList)){
            $this->error('Country id not found');
            return false;
        }

        $this->currency = $countriesList[$countryId]['currency'];

        // Make sure to use the database name we want to establish a connection.
//        Config::set('database.connections.old_database.database', 'grandcp3_influenc_'.$countriesList[$countryId]['db']);
        // Rearrange the connection data
        DB::reconnect('old_database');

        $oldConnection = DB::connection('old_database');
        $oldGroups = $oldConnection->table('favourite_group_list')->whereNull('new_id')->get();
        $favouritesCounts = 0;
        if($this->addGroups){
            foreach ($oldGroups as $oldGroup) {
                $oldUser = $oldConnection->table('users')->where('user_id', $oldGroup->user_id)->first();
                if (!$oldUser) {
                    continue;
                }
                $newSubBrand = Subbrand::whereHas('brand', function ($q) use ($oldUser) {
                    $q->whereHas('user', function ($q2) use ($oldUser) {
                        $q2->where('user_name', $oldUser->username);
                    });
                })->first();
                if (!$newSubBrand) {
                    continue;
                }

                $newGroup = GroupList::create([
                    'name' => $oldGroup->name,
                    'color' => $oldGroup->symbol,
                    'brand_id' => $newSubBrand->brand_id,
                    'sub_brand_id' => $newSubBrand->id,
                    'country_id' => $newSubBrand->country_id,
                    'deleted_at' => !empty($newSubBrand->deleted_at) ? $newSubBrand->deleted_at : null,
                    'created_at' => $newSubBrand->created_at,
                    'created_by' => (!empty($oldGroup->added_by) && $oldGroup->added_by == $oldUser->user_id)?$newSubBrand->brand_id:0,
                ]);

                $oldConnection->table('favourite_group_list')->where('id', $oldGroup->id)->update(['new_id' => $newGroup->id]);

                $favouritesCounts++;

            } //end add groups
            $this->info("Campaigns updated successfully Favourites:".$favouritesCounts);
            return true;
        }

        $oldFavoritesIds = [];
        $oldGroupsFavourites = $oldConnection->table('favorites')->select('favorites.id as favorites_id','instagram_users.id', 'instagram_users.username', 'favorites.user_id', 'favorites.source_user_id', 'favorites.date', 'favorites.group_list_id', 'favorites.is_brand', 'favorites.deleted_at')->join('instagram_users', 'favorites.source_user_id', '=', 'instagram_users.id')->where('favorites.is_brand', 0)->where('go_to_new', 0)->take(20000)->get();

        foreach ($oldGroupsFavourites as $favourite){
            $oldFavoritesIds[] = $favourite->favorites_id;
            $oldUser = $oldConnection->table('users')->where('user_id', $favourite->user_id)->first();
            if (!$oldUser) {
                continue;
            }

            $newSubBrand = Brand::whereHas('user', function ($q2) use ($oldUser) {
                $q2->where('user_name', $oldUser->username);
            })->first();

            if(!$newSubBrand){
                continue;
            }

            $influencer = Influencer::whereHas('user', function ($q) use ($favourite) {
                $q->where('user_name', $favourite->username);
            })->first();
            if(!$influencer){
                continue;
            }

            $create = [
                'influencer_id' => $influencer->id,
                'brand_id' => $newSubBrand->id,
                'date' => !empty($favourite->date)?$favourite->date:Carbon::now(),
                'created_at' => !empty($favourite->date)?$favourite->date:Carbon::now(),
                'deleted_at' => !empty($favourite->deleted_at)?$favourite->deleted_at:null,
                'source' => 'INSTAGRAM'
            ];

            $groupList = [];
            if(!empty($favourite->group_list_id) && is_array(json_decode($favourite->group_list_id, true))){
                foreach (json_decode($favourite->group_list_id, true) as $array){
                    if(isset($array['list_id']) && (int) $array['list_id'] > 0){
                        $oldGroupList = $oldConnection->table('favourite_group_list')->where('id', $array['list_id'])->where('new_id', '>', 0)->first();
                        if($oldGroupList){
                            $newGroupListArray = ['list_id' => (string) $oldGroupList->new_id, 'created_at' => $oldGroupList->created_at??null, 'created_by' => (string) 1, 'deleted_at' => $oldGroupList->deleted_at??null];
                            $groupList[] = $newGroupListArray;
                        }
                    }
                }
            }

            $create['group_list_id'] = !empty($groupList)?$groupList:null;

            BrandFav::create($create);
        }

        $oldConnection->table('favorites')->whereIn('id', $oldFavoritesIds)->update(['go_to_new' => 1]);



        $this->info("Campaigns updated successfully Favourites:");
        return true;
    }

}
