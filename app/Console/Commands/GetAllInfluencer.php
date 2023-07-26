<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\BrancheCampaign;
use App\Models\Brand;
use App\Models\CampaignCountryFavourite;
use App\Models\CampaignInfluencer;
use App\Models\CampaignInfluencerVisit;
use App\Models\CampaignSecret;
use App\Models\ComplimentCampaign;
use App\Models\Country;
use App\Models\Influencer;
use App\Models\Interest;
use App\Models\Nationality;
use App\Models\Subbrand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class GetAllInfluencer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-all-influencer-from-old {country}';

    //php /home/grandcp3/public_html/admins-grand-community-com/artisan app:get-all-influencer-from-old 112

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $countryId = null;
    protected $currency = null;
    protected $addBrands = true;
    protected $addSubBrands = true;
    protected $addBranches = true;
    protected $addCampaigns = true;
    protected $addBrandFavourites = true;
    protected $addCampaignInfluencers = true;


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //ALTER TABLE `campaigns` ADD `new_campaign_id` INT NULL DEFAULT NULL AFTER `id`;
        //ALTER TABLE `users` ADD `new_brand_id` INT NULL DEFAULT NULL AFTER `user_id`;
        //ALTER TABLE `campaign_influencer` ADD `added_to_new` TINYINT(1) NULL DEFAULT '0' AFTER `id`;

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
        $i = 1;
        $oldConnection = DB::connection('old_database');

        $allInfluencers = $oldConnection->table('instagram_users')->where('is_brand', 0)->get();
        $influencersCount = 0;
        $interests = [];
        $oldInterests = $oldConnection->table('interests')->pluck('interest', 'id')->toArray();
        foreach (Interest::pluck('interest', 'id')->toArray() as $key => $row){
            $new = $row;
            foreach ($oldInterests as $oldId => $oldInt){
                if (stripos(strtolower($new), strtolower($oldInt)) !== false) {
                    $interests[$oldId] = $key;
                }
            }
        }
        foreach ($allInfluencers as $oldInfluencer){
            $newInfluencerData = $this->createInfluencer($oldConnection, $oldInfluencer, $interests);
                $influencersCount++;
        }

        $this->info("Campaigns updated successfully Influencers:".$influencersCount);
        return true;
    }

    protected function createInfluencer($oldConnection, $oldInfluencer, $interests = []){
        //fixme::instagram_scrap
        //fixme::snap_scrap
        //fixme::media_instagram

        //fixme::media_data
        //fixme::classification

        $countryId = $this->countryId;
        if(empty($oldInfluencer->username)){
            $oldInfluencer->username = "old_error_".$countryId."_".$oldInfluencer->id;
        }
        $emailName = $oldInfluencer->username."@grand-community.com";
        if($oldInfluencer->username == 'chocomelt.kw' || $oldInfluencer->username == 'twaaq'){
            $emailName = $oldInfluencer->username."_1@grand-community.com";;
        }

        $createUser = [
            'user_name' => $oldInfluencer->username,
            'email' => $emailName,
            'code' => "965", //fixme::
            'phone' => "100000001", //fixme::
            'password' => bcrypt($oldInfluencer->username."_i2g3c4"),
            'type' => 1,
            'created_at' => $oldInfluencer->added_date,
        ];

        $nationality = Nationality::find((int) $oldInfluencer->nationality_id);
        $country = $nationality?Country::where('code', strtolower((string) $nationality->code))->first():null;
        $genders = [0 => 1, 1 => 0];
        $statuses = [0 => 2, 1 => 1, 2 => 4, 3 => 5];
        $matrial = [0 => 0, 1 => 1];

        $newInfluencerUser = User::where('user_name', $oldInfluencer->username)->first();
        if($newInfluencerUser){
            Influencer::where('user_id', $newInfluencerUser->id)->update(['insta_uname' => $oldInfluencer->username, 'active' => $statuses[(int) $oldInfluencer->active]??0, 'country_id' => $countryId, 'gender' => $genders[(int) $oldInfluencer->gender]??0]);
            return true;
        }else{
            $newInfluencerUser = User::create($createUser);
        }

        //'whatsapp_code'
        //'whatsapp'

        $addedInterests = [];
        foreach($interests as $key => $value){
            $oldInterest = !empty($oldInfluencer->interest_id)?explode(',', $oldInfluencer->interest_id):[];
            if(in_array($key, $oldInterest)){
                $addedInterests[] = $value;
            }
        }

        $createInfluencer = [
            'user_id' => $newInfluencerUser->id,
            'name' => !empty($oldInfluencer->full_name)?$oldInfluencer->full_name:$oldInfluencer->username,
            'nationality' => $oldInfluencer->nationality_id,
            'country_id' => $country?$country->id:null,
            'gender' => $genders[(int) $oldInfluencer->gender]??0,
            'insta_uname' => $oldInfluencer->username,
            'snapchat_uname' => $oldInfluencer->snap_username,
            'tiktok_uname' => $oldInfluencer->tiktok_username,
            'created_at' => $newInfluencerUser->added_date,
            'deleted_at' => $oldInfluencer->deleted_at,
            'active' => $statuses[(int) $oldInfluencer->active]??0,
            'marital_status' => $matrial[(int) $oldInfluencer->matrial_status]??null,
            'interest' => $addedInterests,
            'language' => 16,
            'children' => $oldInfluencer->have_child
        ];

        $newBrand = Influencer::create($createInfluencer);

        return true;
    }
}
