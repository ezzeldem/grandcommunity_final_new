<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use App\Http\Services\WebService;


class CampaignTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


	/*** store campaign */
	 /**
     * Create a new job instance.
     *
     * @return void
     */
	protected $webservice ,$campaignId ,$actionType;
    public function __construct(array $data)
    {
        $this->campaignId  = $data['campaign_id'];
		$this->actionType  = $data['action_type'];
		$this->webservice = new WebService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

		switch($this->actionType){
             case "create":
			 case "update":
				$this->webservice->CreateOrUpdateCampaign(["camp_id"=>$this->campaignId,"action_type"=>$this->actionType]);
			break;
			case "delete":
				$this->webservice->deleteCampaign(["camp_id"=>$this->campaignId,"action_type"=>$this->actionType]);
			break;
		}
    }


}
