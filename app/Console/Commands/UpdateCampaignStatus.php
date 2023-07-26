<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Campaign;


class UpdateCampaignStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-campaign-status';

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
        $today = Carbon::today();
        Campaign::whereIn("status", [1])->where(function ($q) use ($today) {
            $q->whereIn('campaign_type', [0, 3, 4])->where("visit_start_date", ">", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where('campaign_type', 1)->where("deliver_start_date", ">", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where("visit_start_date", ">", $today)->where("deliver_start_date", ">", $today);
        })->update(["status" => 4]);

        Campaign::whereIn("status", [4])->where(function ($q) use ($today) {
            $q->whereIn('campaign_type', [0, 3, 4])->where("visit_start_date", "<=", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where('campaign_type', 1)->where("deliver_start_date", "<=", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where("visit_start_date", "<=", $today)->where("deliver_start_date", "<=", $today);
        })->update(["status" => 1]);

        Campaign::whereIn("status", [1])->where(function ($q) use ($today) {
            $q->whereIn('campaign_type', [0, 3, 4])->where("visit_end_date", "<", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where('campaign_type', 1)->where("deliver_end_date", "<", $today);
        })->orWhere(function ($q) use ($today) {
            $q->where("visit_end_date", "<", $today)->where("deliver_end_date", "<", $today);
        })->update(["status" => 2]);

        $this->info("Campaigns updated successfully");
        return true;
    }
}
