<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\BrancheCampaign;
use App\Models\Brand;
use App\Models\BrandDislike;
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
use function Clue\StreamFilter\fun;


class DislikesInfluencer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dislikes-influencer {country}';

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

        $allInfluencers = $oldConnection->table('dislike_influencer')->where('deleted_at', null)->get();
        $influencersCount = 0;
        foreach ($allInfluencers as $oldRow){
            $oldInfluencer = $oldConnection->table('instagram_users')->where('id', $oldRow->influencer_id)->first();
            if(!$oldInfluencer){
                continue;
            }
            $newInfluencer = Influencer::whereHas('user', function ($q) use ($oldInfluencer) {
                $q->where('user_name', $oldInfluencer->username);
            })->first();

            if(!$newInfluencer){
                continue;
            }

            $oldBrand = $oldConnection->table('users')->where('user_id', $oldRow->user_id)->first();
            if(!$oldBrand){
                continue;
            }

            $newBrand = Brand::whereHas('user', function ($q) use ($oldBrand) {
                $q->where('user_name', $oldBrand->username);
            })->first();

            if(!$newBrand){
                continue;
            }

            BrandDislike::updateOrCreate([
                'influencer_id' => $newInfluencer->id,
                'brand_id' => $newBrand->id
            ], [
                'influencer_id' => $newInfluencer->id,
                'brand_id' => $newBrand->id,
            ]);
            $influencersCount++;
        }

        $this->info("Campaigns updated successfully Influencers:".$influencersCount);
        return true;
    }

}
