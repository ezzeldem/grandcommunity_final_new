<?php

namespace App\Console\Commands;

use App\Models\CampaignInfluencer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;


class UpdateCampaignInfluencersStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-campaign-influencers-status';

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
        $today = Carbon::today()->format('Y-m-d');
        $sub3HoursAgo = Carbon::now()->subHours(3)->format('H:i:s');
       $camp = CampaignInfluencer::whereHas('campaign', function ($q){
            $q->where('campaigns.status', 1);
        })->where('campaign_influencers.status', 1)->whereDate('confirmation_date', '<', $today)->orWhere(function ($q) use ($sub3HoursAgo, $today) {
            $q->whereDate('confirmation_date', $today);
            $q->whereTime('confirmation_end_time', '<=', $sub3HoursAgo);
       })->update([
            'status' => 3, 'missed_visit_date' => Carbon::now(), 'confirmation_date' => null, 'confirmation_start_time' => null, 'confirmation_end_time' => null, 'branch_id' => null
        ]);

        $this->info("Campaigns updated successfully");
        return true;
    }
}
