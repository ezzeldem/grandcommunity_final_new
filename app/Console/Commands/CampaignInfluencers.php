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


class CampaignInfluencers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:campaign-influencer {country}';

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

        $oldConnection = DB::connection('old_database');
        $oldCampaigns = $oldConnection->table('campaigns')->where('new_campaign_id', '>', 0)->get();
        foreach ($oldCampaigns as $oldCampaign){
            $this->campaignInfluencers($oldConnection, $oldCampaign);
        }

        $this->info("Campaigns updated successfully Influencers:");
        return true;
    }

    protected function campaignInfluencers($oldConnection, $oldCampaign){
        $allOldCampaignInfluencers = $oldConnection->table('campaign_influencer')->select('campaign_influencer.id as campaign_influencer_id','instagram_users.id', 'campaign_influencer.confirmation_date', 'campaign_influencer.status as campaign_influencer_status', 'campaign_influencer.campaign_type', 'campaign_influencer.reason', 'campaign_influencer.created_at', 'campaign_influencer.note', 'campaign_influencer.added_to_new', 'instagram_users.username')->join('instagram_users', 'campaign_influencer.influencer_id', '=', 'instagram_users.id')->where('campaign_id', $oldCampaign->id)->where('added_to_new',  0)->get();

        $oldCampaignInfluencersIds = $allOldCampaignInfluencers->pluck('campaign_influencer_id')->toArray();

        foreach ($allOldCampaignInfluencers as $rowOldInfuelencer){
            $newInfluencerData = Influencer::where('insta_uname', $rowOldInfuelencer->username)->first();
            if(!$newInfluencerData){
                continue;
            }
            $newCampaignInfluencer =  CampaignInfluencer::create([
                'influencer_id' => $newInfluencerData->id,
                'campaign_id' => $oldCampaign->new_campaign_id,
//                'branch_id' => '',
                'confirmation_date' => $rowOldInfuelencer->confirmation_date,
                'status' => (int) $rowOldInfuelencer->campaign_influencer_status == 3?2:(int) $rowOldInfuelencer->campaign_influencer_status,
                'campaign_type' => $rowOldInfuelencer->campaign_type,
                'reason' => $rowOldInfuelencer->reason,
                'created_at' => $rowOldInfuelencer->created_at,
                'notes' => $rowOldInfuelencer->note,
            ]);

            $oldVisitInfluencer = $oldConnection->table('campaign_influencer_visits')->where('campaign_influencer_id', $rowOldInfuelencer->id)->first();
            if($oldVisitInfluencer){
                CampaignInfluencerVisit::create([
                    'campaign_influencer_id' => $newCampaignInfluencer->id,
                    'status' => $oldVisitInfluencer->status,
                    'used_code_type' => $oldVisitInfluencer->used_code_type,
                    'actual_date' => $oldVisitInfluencer->visit_date,
                ]);
            }

        }

        $oldConnection->table('campaign_influencer')->whereIn('id', $oldCampaignInfluencersIds)->update(['added_to_new' => 1]);
        //End add campaign
    }
}
