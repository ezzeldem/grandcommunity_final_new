<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Influencer;
use Carbon\Carbon;
use App\Http\Traits\SocialScrape\SnapchatScrapeTrait;


class SnapchatScarper extends Command
{
	use SnapchatScrapeTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:snapcaht_scraper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Snapchat scraper';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

	   try{
			$settingCheckDate = Carbon::now()->subDays(10)->toDateString();
			$all_data = Influencer::join('scrape_snapchats', 'scrape_snapchats.influe_brand_id','=','influencers.id')
				->whereDate('scrape_snapchats.last_check_date','<',$settingCheckDate)->where('influencers.active',1)->skip(0)->take(3)->get();
					foreach($all_data as $item){
							if(!$item)
								continue;

					$data = $this->scrapeSnap($item);
			}
		 } catch (\Exception $e) {
				return response()->json(['status' => false], 500);
		}



    }
}
