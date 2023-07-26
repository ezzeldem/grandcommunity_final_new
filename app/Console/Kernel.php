<?php

namespace App\Console;

use App\Console\Commands\InstagramScarper;
use App\Console\Commands\UpdateExpiredRecords;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        Commands\UpdateCampaignInfluencersStatus::class,
        Commands\UpdateCampaignStatus::class,
        Commands\InstagramScarper::class,
		Commands\SnapchatScarper::class,
		Commands\TiktokScarper::class
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
       /// $schedule->command('update:expired')->daily();
        $schedule->command('app:update-campaign-status')->daily();
        $schedule->command('app:update-campaign-influencers-status')->hourly();

	    $schedule->command('update:snapcaht_scraper')->cron('*/20 12-23 * 5-7 ');
		$schedule->command('update:instagram_scraper')->cron('*/30 12-23 * * 1-5');   // */5  12-23 * * * -> every minute from 12 to 23
		$schedule->command('update:tiktok_scraper')->cron('*/40 12-23 * * 1,4');   // */5  12-23 * * * -> every minute from 12 to 23
        $schedule->command('update:twitter_scraper')->cron('*/45 12-23 * * 3,7');
	}

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
