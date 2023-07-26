<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Influencer;
use Carbon\Carbon;
use App\Http\Traits\SocialScrape\InstagramScrapeTrait;


class InstagramScarper extends Command
{
	use InstagramScrapeTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:instagram_scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instagram scraper';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

	   try{	
           $allNotExistData = Influencer::select('influencers.id','influencers.insta_uname','influencers.name','influencers.country_id')
		     ->whereraw('id not in (SELECT influe_brand_id FROM `scrape_instagrams` ORDER BY `influe_brand_id` DESC ) and active = 1 and deleted_at IS NULL')->skip(0)->take(2)->get(); 
           if($allNotExistData)
		   {
					foreach($allNotExistData as $not_item){
						if(!$not_item)
							continue;
			
					      $data = $this->scrapInstagram($not_item);
					}
		   }else{
				$settingCheckDate = Carbon::now()->subDays(10)->toDateString();
				$all_data = Influencer::select('influencers.id','influencers.insta_uname','influencers.name','influencers.country_id','scrape_instagrams.insta_id')->join('scrape_instagrams', 'scrape_instagrams.influe_brand_id','=','influencers.id')
					->whereDate('scrape_instagrams.last_check_date','<',$settingCheckDate)->where(['influencers.active'=>1])->orderBy('scrape_instagrams.last_check_date','asc')->skip(0)->take(2)->get();
						foreach($all_data as $item){
								if(!$item)
									continue;
							
						$data = $this->scrapInstagramById($item);
				}
		     }
		 } catch (\Exception $e) {
				return response()->json(['status' => false], 500);
		}


       
    }
}