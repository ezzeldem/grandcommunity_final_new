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
use App\Models\Subbrand;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class MigrateOldAndNewDatabasesCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-new-and-old-databases-campaign {country}';

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
        //ALTER TABLE `favourite_group_list` ADD `new_id` BIGINT NULL DEFAULT NULL AFTER `id`;
        //ALTER TABLE `favorites` ADD `go_to_new` TINYINT NOT NULL DEFAULT '0' AFTER `id`;

        $countryId = $this->argument('country');
        $this->countryId = $countryId;

        $countriesList = [21 => ['currency' => 'BHD', 'db' => 'bah'], 59 => ['currency' => 'EGP', 'db' => 'egypt'], 97 => ['currency' => 'IQD', 'db' => 'iraq'], 102 => ['currency' => 'JOD', 'db' => 'jo'], 178 => ['currency' => 'SAR', 'db' => 'ksa'], 112 => ['currency' => 'KWD', 'db' => 'kw'], 126 => ['currency' => 'MAD', 'db' => 'moroc'], 159 => ['currency' => 'OMR', 'db' => 'oman'], 173 => ['currency' => 'QAR', 'db' => 'qatar'], 207 => ['currency' => 'TRY', 'db' => 'tk'], 2 => ['currency' => 'AED', 'db' => 'uae'], 71 => ['currency' => 'GBP', 'db' => 'uk']];
        if(!key_exists($countryId, $countriesList)){
            $this->error('Country id not found');
            return false;
        }

        $this->currency = $countriesList[$countryId]['currency'];
        // Make sure to use the database name we want to establish a connection.
        Config::set('database.connections.old_database.database', 'grandcp3_influenc_'.$countriesList[$countryId]['db']);
        // Rearrange the connection data
        DB::reconnect('old_database');
        $i = 1;
        $oldConnection = DB::connection('old_database');

        $allBrands = $oldConnection->table('users')->where('type', 0)->get();
        $campaignsCount = 0;
        $brandsCount = 0;

        foreach ($allBrands as $oldBrand){
            $newBrandData = $this->createBrand($oldConnection, $oldBrand);
            $brandsCount++;
            $oldCampaigns = $oldConnection->table('campaigns')->where('user_id', $oldBrand->user_id)->get();
            foreach ($oldCampaigns as $oldCampaign){
                $this->createCampaign($oldConnection, $oldCampaign, $newBrandData['subBrand'], $newBrandData['branchesIds']);
                $campaignsCount++;
            }
        }

        $this->info("Campaigns updated successfully Campaigns:".$campaignsCount." Brands:".$brandsCount);
        return true;
    }

    protected function createBrand($oldConnection, $oldBrand){
        $countryId = $this->countryId;
        $brandEmail = $oldBrand->email;

        $skipEmailCheck = false;
        if($brandEmail == "Mohamed@grand-community.com"){
            $skipEmailCheck = true;
            $brandEmail = "Mohamed_brand_1@grand-community.com";
        }

        if($brandEmail == "i.reda@grand-community.com" || $brandEmail == "i.reda_brand_1@grand-community.com"){
            $skipEmailCheck = true;
            $brandEmail = "i.reda_brand_".$countryId."@grand-community.com";
        }

        if($brandEmail == "rawan.samy.alsayed@gmail.com"){
            $skipEmailCheck = true;
            $brandEmail = "rawan.samy.alsayed_".$countryId."@gmail.com";
        }

        if($brandEmail == "grandavenueiii@gmail.com"){
            $skipEmailCheck = true;
            $brandEmail = "grandavenueiii_brand_".$countryId."@gmail.com";
        }

        if($brandEmail == "techah62@gmail.com"){
            $skipEmailCheck = true;
            $brandEmail = "techah62".$countryId."@gmail.com";
        }

        if($brandEmail == "m.osama@grand-community.com"){
            $skipEmailCheck = true;
            $brandEmail = "m.osama_brand_".$countryId."@grand-community.com";
        }

        if($brandEmail == "f.asaad@grand-community.com"){
            $skipEmailCheck = true;
            $brandEmail = "f.asaad_brand_".$countryId."@grand-community.com";
        }

        if($brandEmail == "sbaaoud@gmail.com"){
            $skipEmailCheck = true;
            $brandEmail = "sbaaoud_brand_".$countryId."@gmail.com";
        }

        if($brandEmail == "Debenhams_vavavoom@grand-community.com"){
            $skipEmailCheck = true;
            $brandEmail = "Debenhams_vavavoom_brand_".$countryId."@grand-community.com";
        }


        $userName = $oldBrand->username;
        if($userName == "Tarek"){
            $userName = "Tarek_brand_".$countryId;
        }

        if(!$skipEmailCheck){
            $existsUserCheck = User::where('email', $brandEmail)->first();
            if($existsUserCheck){
                $brandEmail = "random_brand_".$countryId."_".$existsUserCheck->email;
            }
        }

        if($userName == "AlShaya"){
            return null;
        }

        $createUser = [
            'user_name' => $userName,
            'email' => $brandEmail,
            'code' => $oldBrand->country_code?:"965",
            'phone' => $oldBrand->phone?:"0000000",
            'password' => $oldBrand->password,
            'type' => 0,
            'created_at' => $oldBrand->date,
        ];

        $exists = true;
        $newBrandUser = User::where('user_name', $userName)->where('type', 0)->first();
        if($newBrandUser){
            $newBrandUser->update($createUser);
        }else{
            $exists = false;
            $newBrandUser = User::create($createUser);
        }

        $oldDetails = $oldBrand->otherDetails?json_decode($oldBrand->otherDetails, true):[];

        $createBrand = [
            'user_id' => $newBrandUser->id,
            'expirations_date' => !empty($oldBrand->expire_date)?$oldBrand->expire_date:null,
            'name' => $oldBrand->name,
            'email' => $oldBrand->email,
            'whatsapp_code' => $newBrandUser->code,
            'whatsapp' => (isset($oldDetails['whatsapp']) && !empty($oldDetails['whatsapp']))?str_replace(['+', ($oldBrand->country_code?:"965")], ['', ''], $oldDetails['whatsapp']):$newBrandUser->phone,
            'address' => (isset($oldDetails['address']) && !empty($oldDetails['address']))?$oldDetails['address']:null,
            'insta_uname' => (isset($oldDetails['instagram']) && !empty($oldDetails['instagram']))?$oldDetails['instagram']:null,
            'facebook_uname' =>  (isset($oldDetails['facebook']) && !empty($oldDetails['facebook']))?$oldDetails['facebook']:null,
            'tiktok_uname' => (isset($oldDetails['tiktok']) && !empty($oldDetails['tiktok']))?$oldDetails['tiktok']:null,
            'snapchat_uname' =>(isset($oldDetails['snapchat']) && !empty($oldDetails['snapchat']))?$oldDetails['snapchat']:null,
            'twitter_uname' => (isset($oldDetails['twitter']) && !empty($oldDetails['twitter']))?$oldDetails['twitter']:null,
            'website_uname' => (isset($oldDetails['website']) && !empty($oldDetails['website']))?$oldDetails['website']:null,
            'created_at' => $newBrandUser->created_at,
            'status' => (int) $oldBrand->active > 0?1:0,
            'country_id' => [$countryId],
        ];

        if($exists){
            $newBrand = Brand::where(['user_id' => $newBrandUser->id])->first();
            if($newBrand && is_array($newBrand->country_id)){
                $createBrand['country_id'] = array_values(array_unique(array_merge($newBrand->country_id, $createBrand['country_id'])));
            }
        }

        $newBrand = Brand::updateOrCreate([
            'user_id' => $newBrandUser->id
        ], $createBrand);

        //createSubbrand
        $defaultSubBrand = Subbrand::updateOrCreate([
            'brand_id' => $newBrand->id
        ],[
            'brand_id' => $newBrand->id,
            'name' => $newBrand->name,
            'preferred_gender' => "both",
            'country_id' => $newBrand->country_id,
            'code_phone' => $newBrandUser->code,
            'phone' => $newBrandUser->phone,
            'code_whats' => $newBrand->whatsapp?$newBrand->whatsapp_code:$newBrandUser->code,
            'whats_number' => $newBrand->whatsapp?:$newBrandUser->phone,
            'expirations_date' => $newBrand->expirations_date,
            'status' => $newBrand->status > 0?1:0,
            'link_insta' => $newBrand->insta_uname,
            'link_facebook' => $newBrand->facebook_uname,
            'link_tiktok' => $newBrand->tiktok_uname,
            'link_snapchat' => $newBrand->snapchat_uname,
            'link_twitter' => $newBrand->twitter_uname,
            'link_website' => $newBrand->website_uname,
            'created_at' => $newBrand->created_at,
        ]);

        //createBranches
        $allOldBranches = $oldConnection->table('user_branches')->where('user_id', $oldBrand->user_id)->get();

        $newBranchesIds = [];
        foreach ($allOldBranches as $oldBranch){
            $newBranch = Branch::updateOrCreate([
                'name' => $oldBranch->branches_name,
                'brand_id' => $newBrand->id,
                'subbrand_id' => $defaultSubBrand->id,
            ],[
                'name' => $oldBranch->branches_name,
                'country_id' => $countryId,
                'brand_id' => $newBrand->id,
                'subbrand_id' => $defaultSubBrand->id,
                'lat' => $oldBranch->lat,
                'lng' => $oldBranch->log,
                'created_at' => $newBrand->created_at,
                'status' => 1
            ]);

            $newBranchesIds[$oldBranch->id] = $newBranch->id;
        }

        return ['brand' => $newBrand, 'subBrand' => $defaultSubBrand, 'branchesIds' => $newBranchesIds];
    }

    protected function createCampaign($oldConnection, $oldCampaign, $newSubBrand = null, $newBranchesIds = []){
        if(!$newSubBrand){
            return null;
        }

        if($oldCampaign->new_campaign_id) {
            $newCampaign = Campaign::find($oldCampaign->new_campaign_id);
            if($newCampaign && !empty($oldCampaign->deleted_at)){
                DB::table('campaigns')->where('id', (int) $oldCampaign->new_campaign_id)->update(['deleted_at' => $oldCampaign->deleted_at]);
            }
        }else{

            //start add campaign
            $newCampaignBranchesIds = [];
            foreach ((!empty($oldCampaign->branch_ids)?json_decode($oldCampaign->branch_ids, true):[]) as $oldBranchId){
                if(key_exists($oldBranchId, $newBranchesIds)){
                    $newCampaignBranchesIds[] = $newBranchesIds[$oldBranchId];
                }
            }

            $newCampaignVouchersBranchesIds = [];
            foreach ((!empty($oldCampaign->voucher_brances)?json_decode($oldCampaign->voucher_brances, true):[]) as $oldBranchId){
                if(key_exists($oldBranchId, $newBranchesIds)){
                    $newCampaignVouchersBranchesIds[] = $newBranchesIds[$oldBranchId];
                }
            }

            $brandId = $newSubBrand->brand_id;
            $subBrandId = $newSubBrand->id;

            //fixme::favouriteCountries done
            //fixme::secrets done
            //fixme::permissions done
            //fixme::quality
            //fixme::influencers
            //fixme::influencersVisits

            $oldNewStatuses = [0 => 0, 1 => 0, 2 => 4, 3 => 1, 4 => 3, 5 => 2, 7 => 4];
            $campaignTypes = [1 => 0, 2 => 1, 3 => 2];
            $create = [
                'name' => $oldCampaign->name,
                'camp_id' => hexdec(uniqid()),
                'brand_id' => $brandId,
                'sub_brand_id' => $subBrandId,
                'gender' => "both",
                'status' => $oldNewStatuses[(int)$oldCampaign->status] ?? 0,
                'objective_id' => 1,
                'campaign_type' => $campaignTypes[(int) $oldCampaign->type]??0,
                'visit_start_date' => $oldCampaign->visitdate_from,
                'visit_from' => $oldCampaign->visitdate_from?"12:00:00":null,
                'visit_end_date' => $oldCampaign->visitdate_to,
                'visit_to' => $oldCampaign->visitdate_to?"12:00:00":null,
                'deliver_start_date' => $oldCampaign->deliverydate_from,
                'deliver_from' => $oldCampaign->deliverydate_from?"12:00:00":null,
                'deliver_end_date' => $oldCampaign->deliverydate_to,
                'deliver_to' => $oldCampaign->deliverydate_to?"12:00:00":null,
                'target_influencer' => (int) $oldCampaign->total_influencer,
                'influencer_per_day' => 0,
                'target_confirmation' => 0,
                'daily_confirmation' => 0,
                'compliment_type' => (int) $oldCampaign->has_voucher > 0?1:0,
                'created_at' => $oldCampaign->created_at,
            ];


            $newCampaign = Campaign::create($create);
            $oldConnection->table('campaigns')->where('id', $oldCampaign->id)->update(['new_campaign_id' => $newCampaign->id]);
            foreach ($newCampaignBranchesIds as $newBranchId){
                BrancheCampaign::updateOrCreate([
                    'campaign_id' => (int) $newCampaign->id,
                    'branche_id' => $newBranchId,
                    'brand_id' => $brandId,
                    'sub_brand_id' => $subBrandId,
                ],[
                    'campaign_id' => (int) $newCampaign->id,
                    'branche_id' => $newBranchId,
                    'brand_id' => $brandId,
                    'sub_brand_id' => $subBrandId,
                    'has_compliment' => in_array($newBranchId, $newCampaignVouchersBranchesIds)?1:0
                ]);
            }


            if((int) $oldCampaign->has_voucher > 0){
                $expiredDate = $oldCampaign->visitdate_from?:($oldCampaign->deliverydate_from?:$newCampaign->created_at->format('Y-m-d'));
                ComplimentCampaign::updateOrCreate([
                    'campaign_id' => $newCampaign->id,
                ],[
                    'campaign_id' => $newCampaign->id,
                    'voucher_expired_date' => $expiredDate,
                    'voucher_expired_time' => "12:00:00",
                    'voucher_amount' => 0,
                    'voucher_amount_currency' => $this->currency,
                ]);
            }

            $campaignFavCountry = CampaignCountryFavourite::updateOrCreate([
                'country_id' => (int) $this->countryId,
                'campaign_id' => $newCampaign->id,
                'list_id' => 0,
            ], [
                'campaign_id' => $newCampaign->id,
                'country_id' => (int) $this->countryId,
                'city_id' => null,
                'list_id' => 0,
            ]);

            $oldSecrets = $oldConnection->table('campaign_user_password')->where('camp_id', $oldCampaign->id)->orderBy('id', 'DESC')->whereNull('deleted_at')->first();

            if($oldSecrets){
                $brand_secret = CampaignSecret::updateOrCreate([
                    'campaign_country_id' => $campaignFavCountry->id,
                ],[
                    'campaign_country_id' => $campaignFavCountry->id,
                    'secret' => $oldSecrets->camp_password,
                    'is_active' => (int) $oldSecrets->active,
                ]);

                $permissions = [1, 2, 3, 4];
                if((int) $newCampaign->campaign_type == 0){
                    $permissions = [1, 2, 4];
                }elseif ((int) $newCampaign->campaign_type == 1){
                    $permissions = [2, 3, 4];
                }

                $brand_secret->permissions()->sync($permissions);
            }

        } //end check if campaign added before
    }
}
